document.getElementById('bName').addEventListener('keyup', validateName);
document.getElementById('fName').addEventListener('keyup', validateFname);
document.getElementById('mName').addEventListener('keyup', validateMname);
document.getElementById('add').addEventListener('keyup', validateAddress);
document.getElementById('age').addEventListener('keyup', validateAge);
document.getElementById('disaPer').addEventListener('keyup', validateDisabilityPer);
document.getElementById('ph').addEventListener('keyup', validatePh);
document.getElementById('aadhar').addEventListener('keyup', validateAadhar);
document.getElementById('service').addEventListener('keyup', validateService);
document.getElementById('recommend').addEventListener('keyup', validateRecommend);

function validateName() {
  const name = document.getElementById('bName');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(name.value)) {

    name.classList.add('is-invalid');
    name.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    name.classList.add('is-valid');
    name.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateFname() {
  const fName = document.getElementById('fName');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(fName.value)) {

    fName.classList.add('is-invalid');
    fName.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    fName.classList.add('is-valid');
    fName.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateMname() {
  const mName = document.getElementById('mName');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(mName.value)) {

    mName.classList.add('is-invalid');
    mName.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    mName.classList.add('is-valid');
    mName.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validatePh() {
  const ph = document.getElementById('ph');
  const re = /^[\d]{10}$/;

  if (!re.test(ph.value)) {

    ph.classList.add('is-invalid');
    ph.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    ph.classList.add('is-valid');
    ph.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateDisabilityPer() {
  const percent = document.getElementById('disaPer');
  const re = /^[\d]{2,3}$/;

  if (!re.test(percent.value)) {

    percent.classList.add('is-invalid');
    percent.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    percent.classList.add('is-valid');
    percent.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateAddress() {
  const add = document.getElementById('add');
  const re = /^[A-Z][a-zA-Z0-9 ,]+[^\W]$/;

  if (!re.test(add.value)) {

    add.classList.add('is-invalid');
    add.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    add.classList.add('is-valid');
    add.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateService() {
  const service = document.getElementById('service');
  const re = /^[A-Z][a-zA-Z0-9 ]+[^\W]$/;

  if (!re.test(service.value)) {

    service.classList.add('is-invalid');
    service.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    service.classList.add('is-valid');
    service.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateRecommend() {
  const recommend = document.getElementById('recommend');
  const re = /^[A-Z][a-zA-Z0-9 ]+[^\W]$/;

  if (!re.test(recommend.value)) {

    recommend.classList.add('is-invalid');
    recommend.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    recommend.classList.add('is-valid');
    recommend.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateAadhar() {
  const aadhar = document.getElementById('aadhar');
  const re = /^[\d]+$/;

  if (!re.test(aadhar.value)) {

    aadhar.classList.add('is-invalid');
    aadhar.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    aadhar.classList.add('is-valid');
    aadhar.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateAge() {
  const age = document.getElementById('age');
  const re = /^[\d]+$/;

  if (!re.test(age.value)) {

    age.classList.add('is-invalid');
    age.classList.remove('is-valid');
    document.getElementById('submit').disabled = true;

  } else {
    age.classList.add('is-valid');
    age.classList.remove('is-invalid');
    document.getElementById('submit').disabled = false;
  }
}

function validateDisability(selected) {
  let id = document.getElementById(selected);

  if (id.value == '-1') {

    document.querySelector('#disability').classList.add('is-invalid');
    document.querySelector('#disability').classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {

    document.querySelector('#disability').classList.add('is-valid');
    document.querySelector('#disability').classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;

  }

}

function validateGender(selected) {
  let id = document.getElementById(selected);

  if (id.value == '-1') {

    document.querySelector('#gender').classList.add('is-invalid');
    document.querySelector('#gender').classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {

    document.querySelector('#gender').classList.add('is-valid');
    document.querySelector('#gender').classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;

  }

}

function validateReligion(selected) {
  let id = document.getElementById(selected);

  if (id.value == '-1') {

    document.querySelector('#religion').classList.add('is-invalid');
    document.querySelector('#religion').classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {

    document.querySelector('#religion').classList.add('is-valid');
    document.querySelector('#religion').classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;

  }

}