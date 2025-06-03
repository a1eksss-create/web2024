function init() {
  const cards = document.querySelectorAll(".product-card");
  cards.forEach((card) => {
    card.addEventListener("click", () => {
      const productId = card.getAttribute("data-product-id");
      showProduct(productId);
    });
  });

  const form = document.getElementById("feedback-form");
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    fetch("./feedback.php", {
      method: "POST",
      body: new URLSearchParams(formData).toString(),
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Ошибка сервера: " + response.status);
        }
        return response.json();
      })
      .then((data) => {
        console.log("Ответ от feedback.php:", data);
        if (data.success) {
          showProduct(formData.get("product_id"));
          form.reset();
        } else {
          alert("Ошибка: " + data.error);
        }
      })
      .catch((error) => {
        alert("Ошибка при отправке: " + error.message);
      });
  });
}

function showProduct(productId) {
  fetch(`./feedback.php?action=read&product_id=${productId}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Ошибка сервера: " + response.status);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Данные о товаре:", data);

      if (data.success && data.product) {
        document.getElementById("modal-title").textContent = data.product.name;
        document.getElementById("modal-image").src = data.product.image;
        document.getElementById("modal-price").textContent =
          "Цена: " + data.product.price + " руб.";
        document.getElementById("modal-description").textContent =
          data.product.description;
        document.getElementById("feedback-product-id").value = productId;
        const feedbackDiv = document.getElementById("modal-feedback");
        feedbackDiv.innerHTML = "";
        if (data.feedback.length > 0) {
          data.feedback.forEach((f) => {
            feedbackDiv.innerHTML += `
                            <div class="feedback">
                                <p><strong>${f.user_name}</strong> (${f.created_at}):</p>
                                <p>${f.comment}</p>
                                <button onclick="editFeedback(${f.id}, '${f.user_name}', '${f.comment}')">Редактировать</button>
                                <button onclick="deleteFeedback(${f.id}, ${productId})">Удалить</button>
                            </div>`;
          });
        } else {
          feedbackDiv.innerHTML = "<p>Пока нет отзывов.</p>";
        }
        document.getElementById("product-modal").style.display = "flex"; // Показываем окно
      } else {
        alert("Ошибка: " + (data.error || "Товар не найден!"));
      }
    })
    .catch((error) => {
      alert("Ошибка при загрузке данных: " + error.message);
    });
}

function editFeedback(id, userName, comment) {
  const newName = prompt("Введите новое имя:", userName);
  const newComment = prompt("Введите новый отзыв:", comment);
  if (newName && newComment) {
    fetch("./feedback.php", {
      method: "POST",
      body: `action=update&id=${id}&user_name=${encodeURIComponent(
        newName
      )}&comment=${encodeURIComponent(newComment)}`,
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          showProduct(document.getElementById("feedback-product-id").value);
        } else {
          alert("Ошибка: " + data.error);
        }
      });
  }
}

// Удаляем отзыв
function deleteFeedback(id, productId) {
  if (confirm("Удалить отзыв?")) {
    fetch("./feedback.php", {
      method: "POST",
      body: `action=delete&id=${id}`,
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          showProduct(productId); // Обновляем отзывы
        } else {
          alert("Ошибка: " + data.error);
        }
      });
  }
}

// Закрываем модальное окно
function closeModal() {
  document.getElementById("product-modal").style.display = "none";
}

// Запускаем скрипт после загрузки страницы
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}
