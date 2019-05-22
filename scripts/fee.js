document.querySelector('#loadImg').style.display = 'none';
let btn = document.querySelector('#sub').disabled = true;


document.querySelector('#calculateBtn').addEventListener('click', function (e) {
  document.querySelector('#loadImg').style.display = 'block';
  setTimeout(calculate, 2000);
});

function calculate() {

  let sFee = document.querySelector('#pFee').value;
  let hFee = document.querySelector('#hPayFee').value;
  let totInput = document.querySelector('#totFee'); ''


  let totalFee;

  if (sFee == '') {

    alert('Payable School Admission Fee cannot be empty!');

  }else if(sFee != '' && hFee == '') { 

    totalFee = parseInt(sFee);
    totInput.value = totalFee;
    document.querySelector('#hPayFee').disabled = true;

  } else{
     
    totalFee = parseInt(sFee) + parseInt(hFee);
    totInput.value = totalFee;
   
  } 
  document.querySelector('#loadImg').style.display = 'none';
  let btn = document.querySelector('#sub').disabled = false;
}