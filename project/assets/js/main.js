// TOGGLE PASSWORD VISIBILITY 
document.querySelectorAll('.toggle-password').forEach(toggle => {
  toggle.addEventListener('click', function () {
    const input = this.parentElement.querySelector('.password-input');
    const showIcon = this.querySelector('.show-pass');
    const hideIcon = this.querySelector('.hide-pass');

    if (input.type === 'password') {
      input.type = 'text';
      showIcon.classList.remove('active');
      hideIcon.classList.add('active');
    } else {
      input.type = 'password';
      hideIcon.classList.remove('active');
      showIcon.classList.add('active');
    }
  });
});

// generate password
function generateStrongPassword(){
  const lower = "abcdefghijklmnopqrstuvwxyz";
  const upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  const num = "0123456789";
  const special = "!@#$%^&£";
  const passLength = 11;

  let pass = "";
  let allChars = "";
  
  while (allChars.length <= passLength){
      for (let i = 0; i < 3; i++) {
          const randLower = Math.floor(Math.random() * lower.length);
          const randUpper = Math.floor(Math.random() * upper.length);
          const randNum = Math.floor(Math.random() * num.length);

          allChars += lower[randLower];
          allChars += upper[randUpper];
          allChars += num[randNum];
      }
  }
  
  const randSpecial = Math.floor(Math.random() * special.length);
  const specialChar = special[randSpecial];


  for (let i = 0; i < passLength; i++) {
      const randPass = Math.floor(Math.random() * allChars.length);

      pass += allChars[randPass];
      if (((i + 1) % 4 === 0 && i !== passLength - 1)){
            pass += "-";
      }
  }
  pass += specialChar;

  password.value = pass;
}


//// Admin script

// Preview Default Image
var loadImg = function(event) {
  const input = event.target;
  const file = input.files?.[0];

  const wrapper = input.closest(".col-md-6") || input.parentElement;
  const preview = wrapper.querySelector(".previewImage");

  const reader = new FileReader();
  reader.onload = function () {
    preview.innerHTML = "";
    const img = document.createElement("img");
    img.className = "img-fluid ratio ratio-1x1";
    img.src = reader.result;
    preview.appendChild(img);
  };
  reader.readAsDataURL(file);
}


// Preview Thumbnails
function previewThumb(input) {
    if (typeof (FileReader) != "undefined") {
        var thumbnails = document.getElementById("thumbnails");
        thumbnails.innerHTML = "";
        
        for (var i = 0; i < input.files.length; i++) {
            var file = input.files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var imgCon = document.createElement("div");
                imgCon.className = "col-6 col-md-6 col-lg-4";
                
                var img = document.createElement("img");
                img.className = "img-fluid ratio ratio-1x1";
                img.src = e.target.result;
                thumbnails.appendChild(imgCon);
                imgCon.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    }
    else {
        alert("This browser does not support HTML5 FileReader.");
    }
}


// Ajax Modal on Product Click
function sendValue(pid) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../main/displayProducts/showProdModal.php", true);
  xhr.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
  );
  xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("modalProdContainer").innerHTML = xhr.responseText;
           const modalAjax = document.getElementById("ajaxProdModal");

          const modal = new bootstrap.Modal(modalAjax);
          modal.show();
    }
  };
  xhr.send("pid=" + encodeURIComponent(pid));
  console.log(xhr.responseText);
}

// test
document.querySelectorAll(".imageUpload").forEach((uploader) => {
  const fileInput = uploader.querySelector(".file-input");
  const previewRow = uploader.querySelector(".previewImagesRow");
  const clearBtn = uploader.querySelector(".clear-btn");

  // Drop Zone
  const dropZone = uploader.querySelector(".drop-zone");
  dropZone.addEventListener("drop", dropHandler);

  // On event, displayimages
  fileInput.addEventListener("change", (e) => {
    displayImages(e.target.files);
  });

  // Drop Function
  function dropHandler(ev) {
    ev.preventDefault();
    const files = [...ev.dataTransfer.items]
      .map((item) => item.getAsFile())
      .filter((file) => file);
    displayImages(files);
  }

  // Display Images Function
  function displayImages(files) {
    for (const file of files) {
      if (file.type.startsWith("image/")) {
        previewRow.innerHTML = "";
        const col = document.createElement("div");
        col.className = "col-12 mx-auto";
        col.style.maxWidth ="500px";

        const img = document.createElement("img");
        img.className = "img-fluid ratio ratio-1x1";
        img.src = URL.createObjectURL(file);

        col.appendChild(img);
        previewRow.appendChild(col);
      }
    }
  }
    

  // Dragover
  window.addEventListener("dragover", (e) => {
    const fileItems = [...e.dataTransfer.items].filter(
      (item) => item.kind === "file",
    );
    if (fileItems.length > 0) {
      e.preventDefault();
      if (!dropZone.contains(e.target)) {
        e.dataTransfer.dropEffect = "none";
      }
    }
  });

  // Drop
  window.addEventListener("drop", (e) => {
    if ([...e.dataTransfer.items].some((item) => item.kind === "file")) {
      e.preventDefault();
    }
  });

  // Dragover
  dropZone.addEventListener("dragover", (e) => {
    const fileItems = [...e.dataTransfer.items].filter(
      (item) => item.kind === "file",
    );
    if (fileItems.length > 0) {
      e.preventDefault();
      if (fileItems.some((item) => item.type.startsWith("image/"))) {
        e.dataTransfer.dropEffect = "copy";
      } else {
        e.dataTransfer.dropEffect = "none";
      }
    }
  });

  // Clear Button
  clearBtn.addEventListener("click", () => {
    for (const img of previewRow.querySelectorAll("img")) {
      URL.revokeObjectURL(img.src);
    }
    previewRow.textContent = "";
  });
});


// Custom radio is selected, show custom div
  const sizeRadio = document.querySelectorAll('input[name="pSize"]');
  const customDiv = document.getElementById('CustomDiv');

  showCustomDiv();
    sizeRadio.forEach(radio => {
      radio.addEventListener('change', showCustomDiv);
  });

  function showCustomDiv() {        
      const selected = document.querySelector('input[name="pSize"]:checked');
      if (selected && selected.value === 'Custom') {
          customDiv.classList.remove('d-none');
      }
      else{
          customDiv.classList.add('d-none');
      }
  }

  
document.addEventListener("DOMContentLoaded", (event) => {
  // Product 
  showCustomDiv();
    sizeRadio.forEach(radio => {
      radio.addEventListener('change', showCustomDiv);
  });

  function showCustomDiv() {        
      const selected = document.querySelector('input[name="pSize"]:checked');
      if (selected && selected.value === 'Custom') {
          customDiv.classList.remove('d-none');
      }
      else{
          customDiv.classList.add('d-none');
      }
  }
  
});

function openFindProduct(){
    document.getElementById("searchBarCon").classList.toggle("active");
}
function closeFindProduct(){
    document.getElementById("searchBarCon").classList.remove("active");
}

// Set Cookie Option
function cookieOption(event) {
  event.preventDefault();
  let choice = event.submitter.value;
  console.log(choice);
  localStorage.setItem("cookie", choice);
  localStorage.getItem("cookie");
  window.location.reload();
}



// User Default Preferences
function setDefault(setId) {
  var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/setDefault.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);

            // If PHP returns JSON
            let data;
            try { data = JSON.parse(this.responseText); } catch (e) { data = { success: true }; }

            if (data.success === false) {
              alert(data.message || "Failed (server said no).");
              return;
            }
          document.querySelectorAll('.set-icon').forEach(i => i.classList.remove('active'));
          // Set clicked icon active
          const icon = document.getElementById("set-" + setId);
          if (icon){
            icon.classList.add('active');
          }

        } else {
          alert("Something went wrong.");
        }
    };
    xhr.send("set_id=" + encodeURIComponent(setId));
}

// User Default Custom Set
function deletePreference(setId) {
  var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/deleteSet.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);
            // If PHP returns JSON
            let data;
            try { data = JSON.parse(this.responseText); } catch (e) { data = { success: true }; }

            if (data.success === false) {
              alert(data.message || "Failed (server said no).");
              return;
            }
            document.getElementById("card-id-" + setId).remove();
        } else {
          alert("Something went wrong.");
        }
    };
    xhr.send("set_id=" + encodeURIComponent(setId));
}

const fingers = ["Thumb","Index","Middle","Ring","Pinky"];

function clearProductOption() {
    // Shape dropdown
    const shape = document.getElementById("pShape");
    shape.value = "";

    // Length radios
    document.querySelectorAll('input[name="pLength"]').forEach(r => {
        r.checked = false;
    });

    // Size radios
    document.querySelectorAll('input[name="pSize"]').forEach(r => {
        r.checked = false;
    });

    // Hide custom size section
    hideCustomDiv();

    // Clear right hand
    fingers.forEach(finger => {
        const input = document.querySelector(`input[name="right[${finger}]"]`);
        input.value = "";
    });

    // Clear left hand
    fingers.forEach(finger => {
        const input = document.querySelector(`input[name="left[${finger}]"]`);
        input.value = "";
    });

}

//User select set change
function selectSetChanged(setId) {

  // clear value of form if none selected
  if (setId == 0) {
      clearProductOption();
      return;
  }

  var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/selectSetChanged.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);
            // If PHP returns JSON
            let sets;
            try {
              sets = JSON.parse(this.responseText); 
            } catch (e) {
              sets = { success: true }; 
            }

            if (sets.success === false) {
              alert(sets.message || "Failed (server said no).");
              return;
            }

            document.getElementById("pShape").value = sets[0].preference.shape; 

            document.querySelectorAll('input[name="pLength"]').forEach(r => {
                r.checked = (r.value === sets[0].preference.length);
              });
            document.querySelectorAll('input[name="pSize"]').forEach(r => {
              r.checked = (r.value === sets[0].preference.size);
            });

            var size = sets[0].preference.size;
              if(size === "Custom"){
                  showCustomDiv();
              }
              else{
                  showCustomDiv();
              }

            fingers.forEach(finger => {
              const input = document.querySelector(`input[name="right[${finger}]"]`);
              input.value = sets[0].right[finger] ?? "";
            });

            fingers.forEach(finger => {
              const input = document.querySelector(`input[name="left[${finger}]"]`);
              input.value = sets[0].left[finger] ?? "";
            });
          } else {
          alert("Something went wrong.");
        }
    };
    xhr.send("set_id=" + encodeURIComponent(setId));
}



// Every cart action 
function cartAction(action, payload, onSuccess) {
  var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/updateCart.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);
            // If PHP returns JSON
            let data;
            try { data = JSON.parse(this.responseText); } catch (e) { data = { success: true }; }

            if (data.success === false) {
            }
            // do something  here
            if (typeof onSuccess === "function") {
                onSuccess(data);
              }

        } else {
          alert("Something went wrong.");
        }
    };
    const params = new URLSearchParams({
        action,
        ...payload
      }).toString();

    xhr.send(params);
}

// Every mail action 
function mailAction(action, payload, onSuccess) {
  var xhr = new XMLHttpRequest();
    xhr.open("POST", "../main/ajax/mailAction.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);
            // If PHP returns JSON
            let data;
            try { data = JSON.parse(this.responseText); } catch (e) { data = { success: true }; }

            if (data.success === false) {
              console.log("AJAX error:", data.message);
              return;
            }
            // do something  here
            if (typeof onSuccess === "function") {
                onSuccess(data);
              }
        } else {
          alert("Something went wrong.");
        }
    };
    const params = new URLSearchParams({
        action,
        ...payload
      }).toString();

    xhr.send(params);
}

// User Default Custom Set
function updateNewsletter(isChecked) {
  const value = isChecked ? 1 : 0;

  var xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/newsletterStatus.php", true);
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status == 200) {
          console.log("Response:", this.responseText);
            // If PHP returns JSON
            let data;
            try { data = JSON.parse(this.responseText); } catch (e) { data = { success: true }; }

            if (data.success === false) {
              alert(data.message || "Failed (server said no).");
              return;
            }
            // Display Text
            const message = document.getElementById("newsletterMessage");
            if(value == 1){
              message.textContent =  "You're now subscribed to exclusive updates!";
            }else{
              message.textContent = "You've unsubscribed from email updates.";
            }
        } else {
          alert("Something went wrong.");
        }
    };
    xhr.send("newsletter_status=" + encodeURIComponent(value));
}



// COOKIE
function addRecentlyViewedProduct(id){
  $recent = $_COOKIE['recent'] ?? [];
  
}

function getRecentlyViewedProducts(){
}

