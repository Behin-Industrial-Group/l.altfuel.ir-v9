var appVersion = "9.1";

window.onload = function() {
    if ('caches' in window) {
      caches.keys().then(function(keyList) {
        keyList.forEach(function(key) {
          caches.delete(key);
        });
      });
    }
    var storedVersion = localStorage.getItem('appVersion');
    if (storedVersion !== appVersion) {
      var confirmed = confirm("نسخه جدیدی از نرم افزار در دسترس است. آپدیت میکنید؟");
      if (confirmed) {
        localStorage.setItem('appVersion', appVersion);
        window.location.reload(true);
        if ('caches' in window) {
          window.caches.keys().then(function(keyList) {
            keyList.forEach(function(key) {
              caches.delete(key);
            });
          });
        }
      }
    }
  };
  