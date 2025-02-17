function initializeIntlTelInput(phoneInput) {
  return intlTelInput(phoneInput, {
    separateDialCode: true,
    autoPlaceholder: "off",
    initialCountry: "ua",
    loadUtilsOnInit:
      "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
  });
}
