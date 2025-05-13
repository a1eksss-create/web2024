class Pizza {
  constructor(stuffing, size) {
    this.stuffings = {
      Маргарита: { price: 500, calories: 300 },
      Пепперони: { price: 800, calories: 400 },
      Баварская: { price: 700, calories: 450 },
    };
    this.sizes = {
      Большая: { price: 200, calories: 200 },
      Маленькая: { price: 100, calories: 100 },
    };
    this.toppings = {
      "сливочная моцарелла": { price: 50, calories: 20 },
      "сырный борт": { price: { Маленькая: 150, Большая: 300 }, calories: 50 },
      "чедер и пармезан": {
        price: { Маленькая: 150, Большая: 300 },
        calories: 50,
      },
    };

    if (!this.stuffings[stuffing] || !this.sizes[size]) {
      throw new Error("Неверный тип или размер пиццы");
    }

    this.stuffing = stuffing;
    this.size = size;
    this.selectedToppings = [];
  }

  addTopping(toppingName) {
    if (
      this.toppings[toppingName] &&
      !this.selectedToppings.includes(toppingName)
    ) {
      this.selectedToppings.push(toppingName);
    }
  }

  removeTopping(toppingName) {
    const index = this.selectedToppings.indexOf(toppingName);
    if (index !== -1) {
      this.selectedToppings.splice(index, 1);
    }
  }

  getStuffing() {
    return this.stuffing;
  }

  getSize() {
    return this.size;
  }

  getToppings() {
    return this.selectedToppings;
  }

  calculatePrice() {
    let price =
      this.stuffings[this.stuffing].price + this.sizes[this.size].price;

    this.selectedToppings.forEach((toppingName) => {
      const toppingPrice = this.toppings[toppingName].price;
      price +=
        typeof toppingPrice === "object"
          ? toppingPrice[this.size]
          : toppingPrice;
    });

    return price;
  }

  calculateCalories() {
    let calories =
      this.stuffings[this.stuffing].calories + this.sizes[this.size].calories;

    this.selectedToppings.forEach((toppingName) => {
      calories += this.toppings[toppingName].calories;
    });

    return calories;
  }
}

let addToCartButton = document.getElementById("addToCart");

let pizzaButtons = document.querySelectorAll(".pizza");
let sizeButtons = document.querySelectorAll(".size");
let toppingCheckboxes = document.querySelectorAll(".topping");

let selectedStuffing = "Маргарита";
let selectedSize = "Маленькая";
let pizza = new Pizza(selectedStuffing, selectedSize);

function updateAddButton() {
  addToCartButton.innerText = `Добавить в корзину за ${pizza.calculatePrice()}₽ (${pizza.calculateCalories()} ККал)`;
}

function highlightButtons() {
  pizzaButtons.forEach((button) => {
    button.classList.toggle(
      "selected",
      button.dataset.stuffing === selectedStuffing
    );
  });

  sizeButtons.forEach((button) => {
    button.classList.toggle("selected", button.dataset.size === selectedSize);
  });
}

function saveSelection() {
  const selection = {
    stuffing: pizza.getStuffing(),
    size: pizza.getSize(),
    toppings: pizza.getToppings(),
  };
  localStorage.setItem("pizzaSelection", JSON.stringify(selection));
}

function loadSelection() {
  const saved = localStorage.getItem("pizzaSelection");
  if (!saved) return;

  const { stuffing, size, toppings } = JSON.parse(saved);

  selectedStuffing = stuffing;
  selectedSize = size;
  pizza = new Pizza(stuffing, size);

  toppings.forEach((toppingName) => {
    pizza.addTopping(toppingName);
  });

  toppingCheckboxes.forEach((checkbox) => {
    checkbox.checked = toppings.includes(checkbox.value);
  });

  highlightButtons();
  updateAddButton();
}

pizzaButtons.forEach((button) =>
  button.addEventListener("click", () => {
    selectedStuffing = button.dataset.stuffing;
    pizza = new Pizza(selectedStuffing, selectedSize);

    toppingCheckboxes.forEach((checkbox) => {
      if (checkbox.checked) pizza.addTopping(checkbox.value);
    });

    highlightButtons();
    updateAddButton();
    saveSelection();
  })
);

sizeButtons.forEach((button) =>
  button.addEventListener("click", () => {
    selectedSize = button.dataset.size;
    pizza = new Pizza(selectedStuffing, selectedSize);

    toppingCheckboxes.forEach((checkbox) => {
      if (checkbox.checked) pizza.addTopping(checkbox.value);
    });

    highlightButtons();
    updateAddButton();
    saveSelection();
  })
);

toppingCheckboxes.forEach((checkbox) =>
  checkbox.addEventListener("change", () => {
    if (checkbox.checked) {
      pizza.addTopping(checkbox.value);
    } else {
      pizza.removeTopping(checkbox.value);
    }
    updateAddButton();
    saveSelection();
  })
);

loadSelection();
highlightButtons();
updateAddButton();
