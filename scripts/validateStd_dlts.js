document.getElementById('sub').addEventListener('submit', function (e) {
  console.log('prevented!');
  e.preventDefault();
});


function validate(selected) {
  let id = document.getElementById(selected);

  if (id.value == 'Select a scheme') {
    document.querySelector('#scheme').classList.add('is-invalid');
    document.querySelector('#scheme').classList.remove('is-valid');
    document.getElementById('sub').disabled = true;
  } else {
    document.querySelector('#scheme').classList.add('is-valid');
    document.querySelector('#scheme').classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateGender(selected) {
  let id = document.getElementById(selected);

  if (id.value == 'Select Gender') {

    document.querySelector('#gender').classList.add('is-invalid');
    document.querySelector('#gender').classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {

    document.querySelector('#gender').classList.add('is-valid');
    document.querySelector('#gender').classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;

  }

}

document.getElementById('stdName').addEventListener('keyup', validateName);
document.getElementById('pob').addEventListener('keyup', validateBOP);
document.getElementById('fname').addEventListener('keyup', validateFname);
document.getElementById('mname').addEventListener('keyup', validateMname);
document.getElementById('address').addEventListener('keyup', validateAddress);
document.getElementById('state').addEventListener('keyup', validateState);
document.getElementById('dist').addEventListener('keyup', validateDist);
document.getElementById('zip').addEventListener('keyup', validateZip);
document.getElementById('class').addEventListener('keyup', validateClass);
document.getElementById('phone').addEventListener('keyup', validatePhone);
document.getElementById('aadhar').addEventListener('keyup', validateAadhar);
document.getElementById('ac').addEventListener('keyup', validateAc);
document.getElementById('ifsc').addEventListener('keyup', validateIFSC);
document.getElementById('branch').addEventListener('keyup', validateBranch);


function validateName() {
  const name = document.getElementById('stdName');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(name.value)) {

    name.classList.add('is-invalid');
    name.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    name.classList.add('is-valid');
    name.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateBOP() {
  const pob = document.getElementById('pob');
  const re = /^[A-Z][a-z]*[^0-9]$/;

  if (!re.test(pob.value)) {

    pob.classList.add('is-invalid');
    pob.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {

    pob.classList.add('is-valid');
    pob.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;

  }
}

function validateFname() {
  const fName = document.getElementById('fname');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(fName.value)) {

    fName.classList.add('is-invalid');
    fName.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    fName.classList.add('is-valid');
    fName.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateMname() {
  const mName = document.getElementById('mname');
  const re = /^[A-Z][a-z ]* [A-Z]{1}[a-z ]*$/;

  if (!re.test(mName.value)) {

    mName.classList.add('is-invalid');
    mName.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    mName.classList.add('is-valid');
    mName.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateAddress() {
  const add = document.getElementById('address');
  const re = /^[A-Z][a-zA-Z0-9 ]+[^\W]$/;

  if (!re.test(add.value)) {

    add.classList.add('is-invalid');
    add.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    add.classList.add('is-valid');
    add.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateState() {
  const state = document.getElementById('state');
  const re = /^[A-Z][a-zA-Z]{4,}$/;

  if (!re.test(state.value)) {

    state.classList.add('is-invalid');
    state.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    state.classList.add('is-valid');
    state.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateDist() {
  const dist = document.getElementById('dist');
  const re = /^[A-Z][a-zA-Z]{4,}$/;

  if (!re.test(dist.value)) {

    dist.classList.add('is-invalid');
    dist.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    dist.classList.add('is-valid');
    dist.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateZip() {
  const zip = document.getElementById('zip');
  const re = /^[0-9]{6}$/;

  if (!re.test(zip.value)) {

    zip.classList.add('is-invalid');
    zip.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    zip.classList.add('is-valid');
    zip.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateClass() {
  const cls = document.getElementById('class');
  const re = /^[\w]+$/;

  if (!re.test(cls.value)) {

    cls.classList.add('is-invalid');
    cls.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    cls.classList.add('is-valid');
    cls.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validatePhone() {
  const phone = document.getElementById('phone');
  const re = /^[\d]{10}$/;

  if (!re.test(phone.value)) {

    phone.classList.add('is-invalid');
    phone.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    phone.classList.add('is-valid');
    phone.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateAadhar() {
  const aadhar = document.getElementById('aadhar');
  const re = /^[\d]+$/;

  if (!re.test(aadhar.value)) {

    aadhar.classList.add('is-invalid');
    aadhar.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    aadhar.classList.add('is-valid');
    aadhar.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateAc() {
  const ac = document.getElementById('ac');
  const re = /^[\d]+$/;

  if (!re.test(ac.value)) {

    ac.classList.add('is-invalid');
    ac.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    ac.classList.add('is-valid');
    ac.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateIFSC() {
  const ifsc = document.getElementById('ifsc');
  const re = /^[A-Z]+[\w]+$/;

  if (!re.test(ifsc.value)) {

    ifsc.classList.add('is-invalid');
    ifsc.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    ifsc.classList.add('is-valid');
    ifsc.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function validateBranch() {
  const branch = document.getElementById('branch');
  const re = /^[A-Z][a-zA-Z]+$/;

  if (!re.test(branch.value)) {

    branch.classList.add('is-invalid');
    branch.classList.remove('is-valid');
    document.getElementById('sub').disabled = true;

  } else {
    branch.classList.add('is-valid');
    branch.classList.remove('is-invalid');
    document.getElementById('sub').disabled = false;
  }
}

function checkSubmit() {
  const name = document.getElementById('stdName').value;
  const pob = document.getElementById('pob').value;
  const fName = document.getElementById('fname').value;
  const mName = document.getElementById('mname').value;
  const address = document.getElementById('address').value;
  const state = document.getElementById('state').value;
  const dist = document.getElementById('dist').value;
  const zip = document.getElementById('zip').value;
  const cls = document.getElementById('class').value;
  const phone = document.getElementById('phone').value;
  const aadhar = document.getElementById('aadhar').value;
  const ac = document.getElementById('ac').value;
  const ifsc = document.getElementById('ifsc').value;
  const branch = document.getElementById('branch').value;

  if (name == '' && pob == '' && fName == '' && mName == '' && address == '' && state == '' && dist == '' && zip == '' && cls == '' && phone == '' || aadhar == '' || ac == '' || ifsc == '' || branch == '') {
    alert('Fields Cannot Be Empty In Order To Successfully Submit Your Data!');
  }
}


