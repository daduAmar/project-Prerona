document.querySelector('#msgPhoto').style.display = 'none';
document.querySelector('#msgBirth').style.display = 'none';
document.querySelector('#msgDisability').style.display = 'none';
document.querySelector('#msgCaste').style.display = 'none';
document.querySelector('#msgIncome').style.display = 'none';
document.querySelector('#msgGuard').style.display = 'none';
document.querySelector('#msgNira').style.display = 'none';
//document.querySelector('#nextPg').disabled = true;

document.querySelector('#bth').style.display = 'none';
document.querySelector('#dis').style.display = 'none';
document.querySelector('#cast').style.display = 'none';
document.querySelector('#incm').style.display = 'none';
document.querySelector('#guard').style.display = 'none';
document.querySelector('#nira').style.display = 'none';

function photoValidate() {
  const fileInputPh = document.querySelector('#stdPhoto');

  const filePathPh = fileInputPh.value;

  let allowedExt = /(\.jpg|\.jpeg|\.png)$/;

  if (!allowedExt.exec(filePathPh)) {

    showError('Only jpg/jpeg/png Extensions Allowed In Photo!', 'msgPhoto');
    document.querySelector('#msgPhoto').style.display = 'block';
    fileInputPh.value = '';
    return false;


  } else {

    //image preview
    if (fileInputPh.files && fileInputPh.files[0]) {

      let reader = new FileReader();
      reader.onload = function (e) {

        document.querySelector('#prePhoto').innerHTML = ' <img src="' + e.target.result + '" class="img-thumbnail" alt="Responsive image" width="150" height="80" >';

      };

      reader.readAsDataURL(fileInputPh.files[0]);

    }

  }
}

function birthValidate() {
  const fileInputBrt = document.querySelector('#birthCerti');
  const filePathBrt = fileInputBrt.value;


  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;



  if (!allowedExt.exec(filePathBrt)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Birth Certificate', 'msgBirth');
    document.querySelector('#msgBirth').style.display = 'block';
    fileInputBrt.value = '';
    return false;
  } else {

    document.querySelector('#bth').style.display = 'block';
    document.querySelector('#bth').textContent = filePathBrt;
  }
}

function disaValidate() {
  const fileInputDis = document.querySelector('#disability');
  const filePathDis = fileInputDis.value;

  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;

  if (!allowedExt.exec(filePathDis)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Disability Certificate', 'msgDisability');
    document.querySelector('#msgDisability').style.display = 'block';
    fileInputDis.value = '';
    return false;
  } else {
    document.querySelector('#dis').style.display = 'block';
    document.querySelector('#dis').textContent = filePathDis;
  }
}

function casteValidate() {
  const fileInputCas = document.querySelector('#caste');
  const filePathCas = fileInputCas.value;

  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;

  if (!allowedExt.exec(filePathCas)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Caste Certificate', 'msgCaste');
    document.querySelector('#msgCaste').style.display = 'block';
    fileInputCas.value = '';
    return false;
  } else {
    document.querySelector('#cast').style.display = 'block';
    document.querySelector('#cast').textContent = filePathCas;
  }
}

function incomeValidate() {
  const fileInputIncm = document.querySelector('#income');
  const filePathIncm = fileInputIncm.value;

  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;

  if (!allowedExt.exec(filePathIncm)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Income Certificate', 'msgIncome');
    document.querySelector('#msgIncome').style.display = 'block';
    fileInputIncm.value = '';
    return false;
  } else {
    document.querySelector('#incm').style.display = 'block';
    document.querySelector('#incm').textContent = filePathIncm;
  }
}

function guardValidate() {
  const fileInputGur = document.querySelector('#guardian')
  const filePathGur = fileInputGur.value;
  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;

  if (!allowedExt.exec(filePathGur)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Guardianship Certificate', 'msgGuard');
    document.querySelector('#msgGuard').style.display = 'block';
    fileInputGur.value = '';
    return false;
  } else {
    document.querySelector('#guard').style.display = 'block';
    document.querySelector('#guard').textContent = filePathGur;
  }
}

function niraValidate() {
  const fileInputNir = document.querySelector('#niramaya');
  const filePathNir = fileInputNir.value;
  let allowedExt = /(\.jpg|\.jpeg|\.png|\.pdf)$/;

  if (!allowedExt.exec(filePathNir)) {
    showError('Only jpg/jpeg/png/pdf Extensions Allowed In Niramaya Health Card', 'msgNira');
    document.querySelector('#msgNira').style.display = 'block';
    fileInputNir.value = '';
    return false;
  } else {
    document.querySelector('#nira').style.display = 'block';
    document.querySelector('#nira').textContent = filePathNir;
  }
}

function showError(msg, id) {
  const msgDiv = document.getElementById(id);
  msgDiv.className = 'alert alert-danger alert-dismissible fade show';
  msgDiv.appendChild(document.createTextNode(msg));
}

document.querySelector('.close').addEventListener('click', function () {
  window.location = 'upload.php';
});