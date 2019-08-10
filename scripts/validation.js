document.querySelector('#errorIcon').style.display = 'none';
document.querySelector('#errorIconEm').style.display = 'none';
document.querySelector('#matchIcon').style.display = 'none';
let data = [];
document.addEventListener('DOMContentLoaded', function (e) {

  const xhr = new XMLHttpRequest();

  xhr.open('GET', 'dbData.php', true);

  xhr.onload = function () {
    if (this.status === 200) {
      dbData = JSON.parse(this.responseText);

      for (let i in dbData['data']) {
        data.push(dbData['data'][i]);
      }
    }
  };
  xhr.onerror = function () {
    console.log('Response error...');
  };

  xhr.send();

});


//checking whether username already exists
document.querySelector('#userName').addEventListener('keyup', function () {

  const inputUsername = document.querySelector('#userName').value;
  const errMsg = document.querySelector('#errMsgUN');
  const re = /^[a-zA-Z]+[a-z0-9]*$/;

  if (re.test(inputUsername)) {

    if (data.includes(inputUsername)) {

      document.querySelector('#iTag').innerHTML = '<i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" title="Username Already Taken!"></i>';
      document.querySelector('#userName').classList.add('is-invalid');
      document.querySelector('#userName').classList.remove('is-valid');
      document.querySelector('#errorIcon').style.display = 'block';
      errMsg.textContent = '';

    } else {

      document.querySelector('#iTag').innerHTML = '';
      document.querySelector('#iTag').innerHTML = '<i class="fas fa-exclamation-circle text-success" data-toggle="tooltip" data-placement="top" title="Username Available..."></i>';
      document.querySelector('#userName').classList.remove('is-invalid');
      document.querySelector('#userName').classList.add('is-valid');
      document.querySelector('#errorIcon').style.display = 'block';
      setTimeout(function () {
        document.querySelector('#errorIcon').style.display = 'none';
      }, 5000);
      errMsg.textContent = '';

    }

  } else {

    errMsg.textContent = 'Username should start with alphabet and can contain only apha-numeric characters!';
    document.querySelector('#errorIcon').style.display = 'none';
    document.querySelector('#userName').classList.add('is-invalid');
    document.querySelector('#userName').classList.remove('is-valid');

  }

});

//checking whether email already exists
document.querySelector('#uEmail').addEventListener('keyup', function () {

  const inputEmail = document.querySelector('#uEmail').value;
  const errMsgEm = document.querySelector('#errMsgEm');
  const reEmail = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

  if (reEmail.test(inputEmail)) {

    if (data.includes(inputEmail)) {

      document.querySelector('#iTag1').innerHTML = '<i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" title="Email Already exists!"></i>';
      document.querySelector('#uEmail').classList.add('is-invalid');
      document.querySelector('#uEmail').classList.remove('is-valid');
      document.querySelector('#errorIconEm').style.display = 'block';
      errMsgEm.textContent = '';

    } else {

      document.querySelector('#iTag1').innerHTML = '<i class="fas fa-exclamation-circle text-success" data-toggle="tooltip" data-placement="top" title="Email Available..."></i>';
      document.querySelector('#uEmail').classList.remove('is-invalid');
      document.querySelector('#uEmail').classList.add('is-valid');
      document.querySelector('#errorIconEm').style.display = 'block';
      setTimeout(function () {
        document.querySelector('#errorIconEm').style.display = 'none';
      }, 5000);
      errMsgEm.textContent = '';
    }

  } else {
    errMsgEm.textContent = 'Provide  a valid Email Id!';
    document.querySelector('#errorIconEm').style.display = 'none';
    document.querySelector('#uEmail').classList.add('is-invalid');
    document.querySelector('#uEmail').classList.remove('is-valid');
  }

});

//password validation
document.querySelector('#password').addEventListener('keyup', function () {

  const password = document.querySelector('#password').value;
  const passErr = document.querySelector('#errMsgPwd');

  if (password.length < 8) {

    passErr.textContent = 'Password must be of 8 characters!';
    document.querySelector('#password').classList.add('is-invalid');
    document.querySelector('#password').classList.remove('is-valid');
    document.querySelector('#cpassword').disabled = true;

  } else if (password.search(/[0-9]/) == -1) {

    passErr.textContent = 'Password must contain atleast one letter,one number & one special character!';
    document.querySelector('#password').classList.add('is-invalid');
    document.querySelector('#password').classList.remove('is-valid');
    document.querySelector('#cpassword').disabled = true;

  } else if (password.search(/[a-zA-Z]/) == -1) {

    passErr.textContent = 'Password must contain atleast one letter,one number & one special character!';
    document.querySelector('#password').classList.add('is-invalid');
    document.querySelector('#password').classList.remove('is-valid');
    document.querySelector('#cpassword').disabled = true;

  } else if (password.search(/\W/) == -1) {

    passErr.textContent = 'Password must contain atleast one letter,one number & one special character!';
    document.querySelector('#password').classList.add('is-invalid');
    document.querySelector('#password').classList.remove('is-valid');
    document.querySelector('#cpassword').disabled = true;

  } else {

    passErr.textContent = '';
    document.querySelector('#password').classList.add('is-valid');
    document.querySelector('#password').classList.remove('is-invalid');
    document.querySelector('#cpassword').disabled = false;

  }


});

//password authentication
document.querySelector('#cpassword').addEventListener('keyup', function () {

  const passwordFrst = document.querySelector('#password').value;
  const passwordCon = document.querySelector('#cpassword').value;
  const conErMsg = document.querySelector('#errMsgCpwd');

  if (passwordFrst != '' && passwordCon.length == 8) {

    if (passwordFrst == passwordCon) {

      document.querySelector('#matchIcon').style.display = 'block';
      document.querySelector('#passIcon').innerHTML = '<i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="top" title="Password Matched"></i>';
      document.getElementById('signUp').disabled = false;
      conErMsg.classList.remove('text-danger');
      conErMsg.classList.add('text-white');
      conErMsg.textContent = "Congrats!...It's a  Match";
      setTimeout(function () {
        conErMsg.textContent = '';
      }, 5000);



    } else {

      document.querySelector('#matchIcon').style.display = 'block';
      document.querySelector('#passIcon').innerHTML = '<i class="fas fa-times-circle  text-danger" data-toggle="tooltip" data-placement="top" title="Password Not Matched!"></i>';
      document.getElementById('signUp').disabled = true;
      conErMsg.textContent = 'Password Not Matched!!';
      setTimeout(function () {
        conErMsg.textContent = '';
      }, 5000);

    }

  }

});

document.querySelector('.close').addEventListener('click', function () {
  window.location = 'index.php';
});



