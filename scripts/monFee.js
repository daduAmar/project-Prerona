document.querySelector('#feeDate').addEventListener('blur', function (e) {

  let feeMon = document.querySelector('#feeMon');
  let feeYear = document.querySelector('#feeYear');

  const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'];

  const d = new Date();
  let month = monthNames[d.getMonth()];
  let year = d.getFullYear();

  feeMon.value = month;
  feeYear.value = year;

});

let feeId = [];
let feeAmt = [];
function loadFee(selected) {
  const id = parseInt(document.getElementById(selected).value);
  //console.log(id);
  const xhr = new XMLHttpRequest();

  xhr.open('GET', 'dbDataFee.php', true);

  xhr.onload = function () {
    if (this.status === 200) {
      sqlRes = JSON.parse(this.responseText);

      for (i = 0; i < (sqlRes['data'].length) / 2; i++) {
        feeId.push(sqlRes['data'][i * 2]);
      }

      for (i = 0; i < (sqlRes['data'].length) / 2; i++) {
        feeAmt.push(sqlRes['data'][(i * 2) + 1]);
      }

      //filling input feilds with data
      assignFee(id);


    }
  };
  xhr.onerror = function () {
    console.log('Response error...');
  };

  xhr.send();

}

function assignFee(id) {

  let schFee = document.querySelector('#sFee');
  let hstFee = document.querySelector('#hstFee');
  let thyFee = document.querySelector('#thyFee');
  let conFee = document.querySelector('#conFee');
  let labelSch = document.querySelector('#lblSch');
  let labelHst = document.querySelector('#lblHst');
  let labelThy = document.querySelector('#lblThy');
  let labelCon = document.querySelector('#lblCon');


  if (feeId.includes(id)) {

    if (id == feeId[0]) {

      schFee.value = feeAmt[0];
      labelSch.textContent = 'School Fee';

    } else if (id == feeId[1]) {

      hstFee.value = feeAmt[1];
      labelHst.textContent = 'Respite Fee';

    } else if (id == feeId[2]) {

      thyFee.value = feeAmt[2];
      labelThy.textContent = 'Therapeutic Service Fee';

    } else {

      conFee.value = feeAmt[3];
      labelCon.textContent = 'Conveyance Service Fee';

    }

  } else {

    let schFeeId = document.querySelector('#sFeeId').value;
    let respiteFeeId = document.querySelector('#hstFeeId').value;
    let thyFeeId = document.querySelector('#thyFeeId').value;
    let conveyFeeId = document.querySelector('#conveyFeeId').value;

    if (schFeeId == 'Select a fee type') {
      schFee.value = '';
    }

    if (respiteFeeId == 'Select a fee type') {
      hstFee.value = '';
    }

    if (thyFeeId == 'Select a fee type') {
      thyFee.value = '';
    }

    if (conveyFeeId == 'Select a fee type') {
      conFee.value = '';
    }

  }

}