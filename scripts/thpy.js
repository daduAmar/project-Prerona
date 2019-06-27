document.querySelector('#therapy').style.display = 'none';

function showCheckBox(checked) {

  if (checked == true) {
    document.querySelector('#therapy').style.display = 'block';
  } else {
    document.querySelector('#therapy').style.display = 'none';
  }
}

document.querySelector('.close').addEventListener('click', function (e) {
  window.location = 'upload.php';
});

