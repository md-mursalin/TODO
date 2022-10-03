
const form = document.getElementById("taskform");
form.addEventListener("submit", e => {
  let value = document.getElementById("task").value;
  if (value.length == 0) {
    alert("Please enter a task");
    e.preventDefault();
  }
});

const close = document.getElementsByClassName("close");

function hide() {
  this.parentElement.remove();
  return false;
}

for (let i = 0; i < close.length; i++) {
  close[i].addEventListener("click", hide, false);
}
