function checkAll() {
  let input = document.getElementsByTagName("input");
  let action = input.value;
  let checkboxes = document.getElementsByTagName("input");

  if (action == 1) {
    for (let i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == "checkbox") {
        checkboxes[i].checked = false;
      }
    }
    input.value = 0;
  } else {
    for (let i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == "checkbox") {
        checkboxes[i].checked = true;
      }
    }
    input.value = 1;
  }
}
