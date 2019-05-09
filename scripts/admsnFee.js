document.querySelector('#transFee').addEventListener('blur', function (e) {

  let sFee = document.querySelector('#pFee').value;
  let hFee = document.querySelector('#hPayFee').value;
  let transFee = document.querySelector('#transFee').value;
  let tFee = document.querySelector('#tFee').value;
  let totInput = document.querySelector('#totFee');

  if (sFee !== '' && hFee !== '' && transFee !== '' && tFee !== '') {
    //sum of fee
    let totalFee = parseInt(sFee) + parseInt(hFee) + parseInt(transFee) + parseInt(tFee);
    totInput.value = totalFee;
  } else {
    let sFee = document.querySelector('#pFee');
    let hFee = document.querySelector('#hPayFee');
    let transFee = document.querySelector('#transFee');
    sFee.value = '';
    hFee.value = '';
    transFee.value = '';
    alert('Fill all the inputs!');

  }



});