function set_id(form_id, form_action, elm_id, val) {
  form = document.getElementById(form_id);
  elm = document.getElementById(elm_id);
  elm.value = val;
  form.action = form_action;
  form.submit();
}