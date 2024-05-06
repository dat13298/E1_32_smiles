function validateForm() {
    let postTitle = document.getElementById('post_title').value.trim();
    let postContent = document.getElementById('post_content').value.trim();
    let mediaDescription = document.getElementById('media_description').value.trim();
    let postImage = document.getElementById('post_image').value.trim();

    if (postTitle === "" || postContent === "" || mediaDescription === "" || postImage === "") {
        Swal.fire({
            title: 'Error!',
            text: 'All fields must be filled out.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    return true;
}

function validateUpdateForm() {
    let postTitle = document.getElementById('post_title').value.trim();
    let postContent = document.getElementById('post_content').value.trim();
    let mediaDescription = document.getElementById('media_description').value.trim();
    let postImage = document.getElementById('post_image').value.trim();

    if (postTitle === "" || postContent === "" || mediaDescription === "") {
        Swal.fire({
            title: 'Error!',
            text: 'All fields must be filled out.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    return true;
}

function confirmDelete(){
    document.addEventListener('DOMContentLoaded', function () {
        const deleteLinks = document.querySelectorAll('.delete');

        deleteLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.href;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    });
}
function previewImage(event) {
    let input = event.target;
    let reader = new FileReader();
    reader.onload = function(){
        let imgElement = document.getElementById("preview-image");
        imgElement.style.display = "block";
        imgElement.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}
function validateFormProduct() {
    let name = document.getElementById('itemName').value.trim();
    let description = document.getElementById('description').value.trim();
    let price = document.getElementById('price').value.trim();
    let image = document.getElementById('post_image');

    if (name === "" || description === ""|| price ==="" || image === "") {
        Swal.fire({
            title: 'Error!',
            text: 'All fields must be filled out.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    return true;
}
function validateFormClinic(){
    let name = document.getElementById('itemName').value.trim();
    let description = document.getElementById('description').value.trim();
    let phoneNumber = document.getElementById('phonenumber').value.trim();
    let address =  document.getElementById('address').value.trim();
    let image = document.getElementById('post_image');
    if (name === "" || description === ""|| phoneNumber ==="" || address ==="" || image === "") {
        Swal.fire({
            title: 'Error!',
            text: 'All fields must be filled out.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    return true;
}