document.querySelector('select[name="opt"]').addEventListener('change', function () {
  const toolGet = document.querySelector('select[name="opt"]').value;
  console.log(toolGet);
  if (toolGet == 'Excel') {
    document.getElementsByClassName('version')[0].style.display = 'block';
  } else {
    document.getElementsByClassName('version')[0].style.display = 'none';
  }
});
function sendQuery() {
  deleteForm();
  var promptValue = document.querySelector('textarea[name="prompt"]').value;
  // var type = document.querySelector('input[name="type"]:checked').value;
  // console.log(type);
  var tool = document.querySelector('select[name="opt"]').value;
  var act = document.querySelector('input[name="type"]:checked').value;
  console.log(`ACT: ${act}`);
  if (tool == 'Excel') {
    var version = document.querySelector('select[name="version"]').value;
  } else {
    var version = '';
  }
  console.log(tool);
  // var url = 'http://localhost:2004/api/?tools=formula&tool=' + tool + '&version=' + version + '&prompt=' + encodeURIComponent(promptValue) + '&act=' + act;

  var url = 'http://localhost:2004/api/';

  var params = new URLSearchParams();
  params.append('tools', 'formula');
  params.append('tool', tool);
  params.append('version', version);
  params.append('prompt', encodeURI(promptValue));
  params.append('act', act);

  fetch(url, {
    method: 'POST',
    body: params,
  })
    .then((response) => response.text())
    .then((data) => {
    //   var resultTextarea = document.querySelector('div[name="result"]');
      var resultTextarea = document.querySelector('textarea[name="result"]');
      var text = data;
      var speed = 30;
      var i = 0;

      function typeWriter() {
        if (i < text.length) {
            resultTextarea.value += text.charAt(i);
          // Menggunakan regex dan metode replace untuk mengganti teks
          text = text.replace(/`excel(.*?)`/g, '<code>$1</code>');
        //   resultTextarea.innerHTML += text.charAt(i);
          i++;
          setTimeout(typeWriter, speed);
        } else {
          text = text.replace(/`excel /g, '');
          text += text.replace(/`/g, '');
        }
      }

      typeWriter();
    })
    .catch((error) => {
      console.error(error);
    });
}
function deleteForm() {
//   var resultTextarea = document.querySelector('div[name="result"]');
  var resultTextarea = document.querySelector('textarea[name="result"]');
  resultTextarea.value = '';
}
// function copyToClipboard() {
//   var resultTextarea = document.querySelector('div[name="result"]');
//   resultTextarea.select();
//   document.execCommand('copy');
//   alert('Copied to clipboard');
//   console.log(resultTextarea.value);
// }
function copyToClipboard() {
  var resultTextarea = document.querySelector('textarea[name="result"]');
  resultTextarea.select();
  navigator.clipboard
    .writeText(resultTextarea.value)
    .then(() => {
      alert('Copied to clipboard');
      console.log(resultTextarea.value);
    })
    .catch((error) => {
      console.error('Failed to copy to clipboard:', error);
    });
}
