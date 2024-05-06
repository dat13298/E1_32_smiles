document.addEventListener("DOMContentLoaded", function () {
  let currentPage = 1;
  let itemsPerPage = 0;
  const maxPageNumbers = 7;
  const url = window.location.href;
  const currentPath = window.location.pathname;
  const directory = currentPath.substring(19, currentPath.lastIndexOf('/'));
  switch (directory) {
    case 'product':
      itemsPerPage = 12;
      break;
    case 'contact-us':
      itemsPerPage = 4;
      break;
    default:
      itemsPerPage = 0;
      break;
  }
  function displayData(data) {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const dataToDisplay = data.slice(startIndex, endIndex);
    let dataHTML = "";
    for (let i = 0; i < dataToDisplay.length; i++) {
      switch (directory) {
        case 'product':
          dataHTML +=
              '<a href="show-detail.php?id=' + dataToDisplay[i].product_id + '">' +
              '<div class="col-sm-4 col-md-4 col-lg-3 card-col">' +
              '<div class="card product_show">' +
              '<img src="' + convertImagePath(dataToDisplay[i].media_path) + '" alt="image" style="width: 100%; height: 100%">' +
              '<div class="box-card">' +
              '<h4><b>' + dataToDisplay[i].product_name + '</b></h4>' +
              '<h6>Price</h6>' +
              '<p>' + dataToDisplay[i].product_price + '$</p>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '</a>';
          break;
        case 'contact-us':
          dataHTML +=
              '<div class="col-md-6 col-sm-6 card-col">' +
              '<div class="card row">' +
              '<div class="col-md-4 col-sm-4 clinic_img">' +
              '<img src="' + convertImagePath(dataToDisplay[i].media_path) + ' " alt="image" style="width:100%">' +
              '</div>' +
              '<div class="clinic_info box-card col-md-8 col-sm-8">' +
              '<h4><b>' +dataToDisplay[i].clinic_name + '</b></h4>' +
              '<h6>Description</h6>' +
              '<p>' + dataToDisplay[i].clinic_description + '</p>' +
              '<div>' +
              '<p><i class="fa fa-phone" aria-hidden="true"></i>' + dataToDisplay[i].clinic_phone_number + '</p>'+
              '</div>' +
              '<div>' +
              '<p><i class="fa fa-home" aria-hidden="true"></i>' + dataToDisplay[i].clinic_address + '</p>'+
              '</div>' +
              '<button class="btn btn-primary" onclick="showLocation(\'' + dataToDisplay[i].clinic_address + '\')">' +
              '<i class="fa fa-map-marker" aria-hidden="true"></i>Location' +
              '</button>' +
              '</div>' +
              '</div>' +
              '</div>';
          break;
        default:
          dataHTML = "";
          break;
      }
    }
    document.getElementById("data-list").innerHTML = dataHTML;
  }
  function generatePageNumbers(totalPages) {
    let i;
    let pageNumbersHtml = '';
    let startPage, endPage;
    if (totalPages <= maxPageNumbers) {
      startPage = 1;
      endPage = totalPages;
    } else {
      const maxPageNumbersToShow = maxPageNumbers - 2; // Trừ đi 2 nút "Prev" và "Next"
      const sidePageNumbers = Math.floor((maxPageNumbersToShow - 1) / 2); // Số lượng nút trang trên mỗi bên trước và sau trang hiện tại
      if (currentPage <= sidePageNumbers + 1) {
        startPage = 1;
        endPage = maxPageNumbersToShow;
      } else if (currentPage >= totalPages - sidePageNumbers) {
        startPage = totalPages - maxPageNumbersToShow + 1;
        endPage = totalPages;
      } else {
        startPage = currentPage - sidePageNumbers;
        endPage = currentPage + sidePageNumbers;
      }
    }
    if (startPage > 1) {
      pageNumbersHtml += '<a href="#" data-page="1">&laquo;</a>'; // Nút "Prev"
      if (startPage > 2) {
        pageNumbersHtml += '<span>...</span>';
      }
    }
    for (i = startPage; i <= endPage; i++) {
      const activeClass = i === currentPage ? "active" : "";
      pageNumbersHtml += '<a href="#" class="' + activeClass + '" data-page="' + i + '">' + i + '</a>';
    }
    if (endPage < totalPages) {
      if (endPage < totalPages - 1) {
        pageNumbersHtml += '<span>...</span>';
      }
      pageNumbersHtml += '<a href="#" data-page="' + totalPages + '">&raquo;</a>';
    }
    document.getElementById("pagination").innerHTML = pageNumbersHtml;
    const paginationLinks = document
        .getElementById("pagination")
        .getElementsByTagName("a");
    for (i = 0; i < paginationLinks.length; i++) {
      paginationLinks[i].addEventListener("click", function (event) {
        event.preventDefault();
        currentPage = parseInt(this.getAttribute("data-page"));
        loadData();
      });
    }
  }
  function displayPagination(data) {
    const numPages = Math.ceil(data.length / itemsPerPage);
    generatePageNumbers(numPages);
  }
  function loadData() {
    const xhr = new XMLHttpRequest();
    switch (directory) {
      case 'product':
        xhr.open("GET", "get_products_ajax.php?page=" + currentPage, true);
        break;
      case 'contact-us':
        xhr.open("GET", "get_contact_ajax.php?page=" + currentPage, true);
        break;
    }
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        displayData(response);
        displayPagination(response);
      }
    };
    xhr.send();
  }
  loadData();
});
function validateFormContact(){
  document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const nameInput = document.getElementById('form_name');
    const titleInput = document.getElementById('form_title');
    const emailInput = document.getElementById('form_email');
    const phoneInput = document.getElementById('form_phone');
    const messageInput = document.getElementById('form_message');
    let isValid = true;
    if (nameInput.value.trim() === '') {
      displayError(nameInput, 'Firstname is required.');
      isValid = false;
    } else {
      removeError(nameInput);
    }
    if (titleInput.value.trim() === '') {
      displayError(titleInput, 'Title is required.');
      isValid = false;
    } else {
      removeError(titleInput);
    }
    if (emailInput.value.trim() === '') {
      displayError(emailInput, 'Valid email is required.');
      isValid = false;
    } else {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(emailInput.value)) {
        displayError(emailInput, 'Please enter a valid email address.');
        isValid = false;
      } else {
        removeError(emailInput);
      }
    }
    if (phoneInput.value.trim() !== '') {
      const phoneRegex = /^\d{10,}$/;
      if (!phoneRegex.test(phoneInput.value)) {
        displayError(phoneInput, 'Please enter a valid phone number.');
        isValid = false;
      } else {
        removeError(phoneInput);
      }
    } else {
      removeError(phoneInput);
    }
    if (messageInput.value.trim() === '') {
      displayError(messageInput, 'Please, leave us a message.');
      isValid = false;
    } else {
      removeError(messageInput);
    }
    if (isValid) {
      event.target.submit();
    }
  });

  // Hiển thị thông báo lỗi
  function displayError(input, message) {
    const errorElement = input.parentNode.querySelector('.help-block');
    errorElement.innerText = message;
    input.classList.add('is-invalid');
  }

  // Xóa thông báo lỗi
  function removeError(input) {
    const errorElement = input.parentNode.querySelector('.help-block');
    errorElement.innerText = '';
    input.classList.remove('is-invalid');
  }
}
// convert img path
function convertImagePath(dbPath) {
  return dbPath.replace('../../', '../');
}