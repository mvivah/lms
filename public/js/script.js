let ERROR_COUNT = 0

try{
    document.getElementById('userForm').addEventListener('submit',function(e){
        e.preventDefault();
        const USER_INDEX = document.getElementById('user_id');
        const USER_ID = (USER_INDEX == null)? null:USER_INDEX.value;
        let formData = new FormData(this);
        if( USER_ID !== null && USER_ID !=='' ){
            formData.append("_method", "PUT");
            axios.post(`/users/${USER_ID}`,formData)
            .then( response => {
                $('#userForm')[0].reset();
                $("#userModal").modal("hide");
                showAlert(response.data[0], response.data[1]);
                setTimeout(() => {
                  location.reload();
                }, 2000);
            } )
             .catch( error => validate(error.response.data.errors) );
        }
        else{
            axios.post('/users',formData)
            .then( response=>{
                $('#userForm')[0].reset();
                $("#userModal").modal("hide");
                showAlert(response.data[0], response.data[1]);
                setTimeout(() => {
                  location.reload();
                }, 2000);
            })
            .catch( error => validate(error.response.data.errors) );
        }
    })

    //Edit users
    let editButtons = document.querySelectorAll('.editUser');
    editButtons.forEach( editButton => {
        editButton.addEventListener('click', e =>{
            axios.get(`/users/${e.target.id}/edit`)
            .then( response => {
                data = response.data
                document.getElementById('user_id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('gender').value = data.gender;
                document.getElementById('birthdate').value = data.birthdate;
                document.getElementById('email').value = data.email;
                document.getElementById('phone').value = data.phone;
                document.getElementById('user_login').style.display = 'none';
                $('#userModal').modal('show');
            })
            .catch( error => validate(error.response.data.errors) );
        });
    });

    //Delete users
    let deleteButtons = document.querySelectorAll('.deleteUser');
    deleteButtons.forEach( deleteButton => {
            deleteButton.addEventListener('click', e =>{
                confirmDeletion('users',e.target.id);
            });
    });
} catch (error) {

}



const validate = response => {
    Object.keys(response).forEach( item => {
        const itemDom = document.getElementById(item);
        const errorMessage = response[item];
        const errorMessages = document.querySelectorAll('.text-danger');
        errorMessages.forEach((Element) => Element.textContent = '');
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach((Element) =>Element.classList.remove('border', 'border-danger'));
        itemDom.classList.add('border', 'border-danger');
        itemDom.insertAdjacentHTML('afterend',`<div class="text-danger">${errorMessage}</div>`);

    });
    return false;
}

const confirmDeletion = (url,id) =>{
    document.getElementById('target_url').value = url;
    document.getElementById('target_id').value = id;
    $('#warnModal').modal('show');
}

const executeDeletion = () =>{
    let url = document.getElementById('target_url').value;
    let element = document.getElementById('target_id').value;
    axios.delete(`${url}/${element}`)
    .then( response => {
        $('#warnModal').modal('hide');
        showAlert(response.data[0], response.data[1]);
        setTimeout(() => {
          location.reload();
        }, 2000);
    })
    .catch( error => {
        console.log(error)
    });

}

const showAlert = (alert_class, alert_message) => {
    let  notyf = new Notyf();
    notyf.open({
      type: alert_class,
      message: alert_message,
      duration: 2000,
      ripple: true,
      dismissible: true,
      position: {
        x: "right",
        y: "top"
      }
    });
  };
