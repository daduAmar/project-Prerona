function fileValidate() {

  //console.log('working....');
  const fileInput = document.querySelector('#photo');
  const filePath = fileInput.value;
  let allowedExt = /(\.jpg|\.jpeg|\.png)$/;

  if (!allowedExt.exec(filePath)) {
    alert('Only .jpg/.jpeg/.png extension photo is allowed!');
    fileInput.value = '';
    return false;

  } else {
    //image preview
    if (fileInput.files && fileInput.files[0]) {

      let reader = new FileReader();
      reader.onload = function (e) {

        document.querySelector('#prePhoto').innerHTML = ' <img src="' + e.target.result + '" class="img-thumbnail" alt="Responsive image" width="150" height="100" >';

      };

      reader.readAsDataURL(fileInput.files[0]);

    }
  }
}

document.querySelector('.close').addEventListener('click', function () {
  window.location = 'ddrc.php';
});


