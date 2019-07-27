<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
  flatpickr(document.getElementById('date'), {
    locale: 'ja',
    dateFormat: "Y/m/d",
    maxDate: new Date()  //やりたいこと3 minDate→maxDateにすることで、それ以前の日付を入力出来るようになった。
  });
</script>