document.querySelector('#loadImg').style.display = 'none';
document.querySelector('#calculateBtn').addEventListener('click', function (e) {
  document.querySelector('#loadImg').style.display = 'block';
  setTimeout(calculate, 3000);
});

function calculate() {

  let sFee = document.querySelector('#pFee').value;
  let hFee = document.querySelector('#hPayFee').value;
  let transFee = document.querySelector('#transFee').value;
  let tFee = document.querySelector('#tFee').value;
  let totInput = document.querySelector('#totFee'); ''


  let totalFee;

  if (sFee == '') {
    alert('Payable School Admission Fee cannot be empty!');
  }

  if (sFee != '' && hFee == '' && transFee == '' && tFee == '') { //s

    //sum of fee
    totalFee = parseInt(sFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee != '' && transFee == '' && tFee == '') {//sh

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(hFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee != '' && transFee != '' && tFee == '') {//shtr

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(hFee) + parseInt(transFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee != '' && transFee == '' && tFee != '') {//shth

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(hFee) + parseInt(tFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee == '' && transFee != '' && tFee != '') {//strth

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(transFee) + parseInt(tFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee == '' && transFee != '' && tFee == '') {//str

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(transFee);
    totInput.value = totalFee;

  } else if (sFee != '' && hFee == '' && transFee == '' && tFee != '') {//sth

    //sum of fee
    totalFee = parseInt(sFee) + parseInt(tFee);
    totInput.value = totalFee;

  } else {//shtrth
    //sum of fee
    totalFee = parseInt(sFee) + parseInt(hFee) + parseInt(transFee) + parseInt(tFee);
    totInput.value = totalFee;

  }


  document.querySelector('#loadImg').style.display = 'none';
}