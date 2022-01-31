const monthDonate = document.querySelector(".main__click");
const mainDisplay = document.querySelector(".main__display");

monthDonate.addEventListener("click", function() {
if (monthDonate.checked) {
  mainDisplay.classList.remove("main__display");
} else {
  mainDisplay.classList.add("main__display");
}
});

const validateObject = {
dateValid: /^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](20)[0-9]{2}$/,
numValid: /^[0-9]+$/,
yearValid: /^$|[0-5]/
};

const formDeposit = document.querySelector('.form');
const textMessage = document.querySelector('.text__message');

function validMessage (formDeposit, el, message) {
  formDeposit.classList.remove('is-invalid');
  el.innerHTML = message;
}

function notvalidMessage (formDeposit, el, message) {
  formDeposit.classList.add('is-invalid');
  el.innerHTML = message;
}

const numberValid = {
first: formDeposit.deposit.value
}

const valid = function (reg, formIn) {
if (reg.test(formIn)) {
  validMessage(formDeposit, textMessage, '');
  console.log('yes');
} else {
  validMessage(formDeposit, textMessage, 'Не более 5-ти'); 
  console.log('no');
  }

}

formDeposit.onsubmit = async (e) => {
  e.preventDefault();
  if(formDeposit.yearOrMonth.value ==="year") {
    valid(validateObject.yearValid, formDeposit.timeDeposit.value);
  }
  const form = new FormData(formDeposit);

  const formData = {
    date: form.get('date'),
    deposit: form.get('deposit'),
    timeDeposit: form.get('timeDeposit'),
    percent: form.get('percent'),
    depositAddSum: form.get('depositAddSum'),
    everyMonth: form.get('everyMonth'),
    yearOrMonth: form.get('yearOrMonth')
  }

  const formRules = {
    "deposit": {
      min: 1000,
      max: 3000000
    }, 
    "depositAddSum": {
      min: 1000,
      max: 3000000
    },
    "percent": {
    min: 3,
    max: 100
    }
  }
  
  const deposit = Number(form.get('deposit'));
  const depositAddSum = Number(form.get('depositAddSum'));
  const everyMonth = form.get('everyMonth');
  const percent = form.get('percent');
  const timeDeposit = form.get('timeDeposit');
  
  if (deposit < formRules["deposit"].min || deposit > formRules["deposit"].max) {
    document.querySelector('.error__result').innerHTML = 'Сумма вклада: ошибка допустимого диапазона. Введите число от 1 000 до 3 000 000!';
    return false;
  } else {
    document.querySelector('.error__result').innerHTML = '';
  }
  if (everyMonth) {
  if ( (depositAddSum < formRules["depositAddSum"].min || depositAddSum > formRules["depositAddSum"].max) && form.get('depositAddSum') !== null) {
    document.querySelector('.error__result').innerHTML = 'Сумма пополнения вклада: ошибка допустимого диапазона. Введите число от 1 000 до 3 000 000!';
    document.querySelector('.result').innerHTML = '';
    return false;
  } else {
    document.querySelector('.error__result').innerHTML = '';
  }
}
if (percent < formRules["percent"].min || percent > formRules["percent"].max) {
  document.querySelector('.error__result').innerHTML = 'Максимальный процент банка от 3 до 100!';
  return false;
} else {
  document.querySelector('.error__result').innerHTML = '';
}
if (!timeDeposit) {
  document.querySelector('.error__result').innerHTML = 'Пожалуйста, укажите срок вклада!';
  return false;
} else {
  document.querySelector('.error__result').innerHTML = '';
}

  const response = await fetch('calc.php', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json;charset=utf-8'
  },
    body: JSON.stringify(formData),
  });
  
  if (response.ok) {
    let result = await response.text();
    document.querySelector('.result').innerHTML = `Ваша прибыль будет составлять: ${result}`;;
  }

}

































































// function validate (reg, input) {
//   btnClicked.onclick = function(e) {
//     e.preventDefault();
//     if (!reg.test(input)) {
//       console.log('no');
//      }
//       else {
//         console.log ('yes');
//       }
//       return
//     } ;
// }

// validate(dateValid, formDeposit.date.value)

  

// document.querySelector('.btn').onclick = function(e) {
//   e.preventDefault();
//   if (!validate(dateValid, formDeposit.date.value)) {
//     console.log('no') }
//     else {
//       console.log ('yes')
//     }
//   }