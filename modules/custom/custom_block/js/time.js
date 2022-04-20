(function ($, Drupal, window, document) {
  'use strict';
  Drupal.behaviors.search = {
    attach: function (context, settings) {
      var timezone = drupalSettings.custom_block.timezone;
      let options = {
        timeZone: timezone,
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: 'numeric',
        hour12: true
      };

      const ordinalPluralRules = new Intl.PluralRules("en", {
        type: "ordinal"
      });

      const ordinalSuffixes = {
        "one": "st",
        "two": "nd",
        "few": "rd",
        "other": "th"
      };

      function ordinalSuffix(x) {
        const ordinal = ordinalPluralRules.select(x);
        const suffix = ordinalSuffixes[ordinal];
        return `${x}${suffix}`;
      }

      setInterval(() => {
        let datePart = (new Date()).toLocaleString([], options).replace(',', ' -').substring(0, 2)
        const dayWithSuffix = ordinalSuffix(Number(datePart));
        let finalDate = (new Date()).toLocaleString([], options).replace(',', ' -').replace(/^.{2}/g, dayWithSuffix);
        $("#currentTime").text(finalDate);
      }, 1000);
    }
  };
})(jQuery, Drupal, this, this.document);
