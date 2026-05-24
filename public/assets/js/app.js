(function () {
  'use strict';

  document.querySelectorAll('[data-validate]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  var suggestBtn = document.getElementById('btnSuggestDescription');
  if (suggestBtn && window.AI_SUGGEST_URL) {
    suggestBtn.addEventListener('click', async function () {
      var name = document.getElementById('name').value;
      var notes = document.getElementById('draft_notes').value;
      var categoryId = document.getElementById('category_id').value;
      var desc = document.getElementById('description');
      var fd = new FormData();
      fd.append('name', name);
      fd.append('notes', notes);
      fd.append('category_id', categoryId);
      suggestBtn.disabled = true;
      try {
        var res = await fetch(window.AI_SUGGEST_URL, { method: 'POST', body: fd });
        var data = await res.json();
        if (data.suggested) {
          desc.value = data.suggested;
          document.getElementById('ai_suggested').value = data.suggested;
          document.getElementById('ai_input').value = notes;
          alert(data.disclaimer || 'Review AI content before saving.');
        }
      } catch (err) {
        alert('Could not generate suggestion.');
      }
      suggestBtn.disabled = false;
    });

    var productForm = document.getElementById('productForm');
    if (productForm) {
      productForm.addEventListener('submit', function () {
        var suggested = document.getElementById('ai_suggested').value;
        var accepted = document.getElementById('description').value;
        var input = document.getElementById('ai_input').value;
        if (suggested && window.AI_LOG_URL) {
          var fd = new FormData();
          fd.append('_csrf', window.CSRF);
          fd.append('suggested', suggested);
          fd.append('accepted', accepted);
          fd.append('input', input);
          navigator.sendBeacon(window.AI_LOG_URL, fd);
        }
      });
    }
  }
})();
