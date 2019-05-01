document.querySelector('#errorIcon').style.display = 'none';
document.querySelector('#errorIconEm').style.display = 'none';
let data = [];
document.addEventListener('DOMContentLoaded', function(e){

  const xhr = new XMLHttpRequest();

  xhr.open('GET', 'dbData.php', true);
 
  xhr.onload = function() {
    if (this.status === 200) {
      dbData = JSON.parse(this.responseText);

      for (let i in dbData['data']) {
        data.push(dbData['data'][i]);
      }
   }
  };
  xhr.onerror = function() {
    console.log('Response error...');
  };

  xhr.send();
  
});


//checking whether username already exists
 document.querySelector('#userName').addEventListener('keyup', function(){

  let inputUsername = document.querySelector('#userName').value;

    if (data.includes(inputUsername)) {
    
      document.querySelector('#iTag').innerHTML = '<i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" title="Username Already Taken!"></i>';
      document.querySelector('#userName').classList.add('is-invalid');
      document.querySelector('#userName').classList.remove('is-valid');
      document.getElementById('signUp').disabled = true;
      document.querySelector('#errorIcon').style.display = 'block';
    } 
    else{
      document.querySelector('#iTag').innerHTML = '';
      document.querySelector('#iTag').innerHTML = '<i class="fas fa-exclamation-circle text-success" data-toggle="tooltip" data-placement="top" title="Username Available..."></i>';
      document.querySelector('#userName').classList.remove('is-invalid');
      document.querySelector('#userName').classList.add('is-valid');
      document.getElementById('signUp').disabled = false;
      document.querySelector('#errorIcon').style.display = 'block'
    }
  
 });

//checking whether email already exists
document.querySelector('#uEmail').addEventListener('keyup', function(){

  let inputEmail = document.querySelector('#uEmail').value;

    if (data.includes(inputEmail)) {

      document.querySelector('#iTag1').innerHTML = '<i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" title="Email Already exists!"></i>';
      document.querySelector('#uEmail').classList.add('is-invalid');
      document.querySelector('#uEmail').classList.remove('is-valid');
      document.getElementById('signUp').disabled = true;
      document.querySelector('#errorIconEm').style.display = 'block';
      
    }else{

      document.querySelector('#iTag1').innerHTML = '<i class="fas fa-exclamation-circle text-success" data-toggle="tooltip" data-placement="top" title="Email Available..."></i>';
      document.querySelector('#uEmail').classList.remove('is-invalid');
      document.querySelector('#uEmail').classList.add('is-valid');
      document.getElementById('signUp').disabled = false;
      document.querySelector('#errorIconEm').style.display = 'block';
    }
 
 });



