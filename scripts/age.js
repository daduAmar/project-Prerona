document.querySelector('#dob').addEventListener('blur', function(e) {
  const birthday = document.querySelector('#dob').value;
  const ageField = document.querySelector('#age');

  var dates = birthday.split('-');
  var d = new Date();

  var userday = dates[2];
  var usermonth = dates[1];
  var useryear = dates[0];

  var curday = d.getDate();
  var curmonth = d.getMonth() + 1;
  var curyear = d.getFullYear();

  var age = curyear - useryear;
  var month = Math.abs(curmonth - usermonth);
  var days = Math.abs(curday - userday);

  if (curmonth < usermonth || (curmonth == usermonth && curday < userday)) {
    age--;
  }

  ageField.value = age;
});
