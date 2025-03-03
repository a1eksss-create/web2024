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

  addTopping(topping) {
    if (this.toppings[topping] && !this.selectedToppings.includes(topping)) {
      this.selectedToppings.push(topping);
    }
  }

  removeTopping(topping) {
    const index = this.selectedToppings.indexOf(topping);
    if (index !== -1) {
      this.selectedToppings.splice(index, 1);
    }
  }

  getToppings() {
    return this.selectedToppings;
  }

  getSize() {
    return this.size;
  }

  getStuffing() {
    return this.stuffing;
  }

  calculatePrice() {
    let priceStuffing = this.stuffings[this.stuffing].price;
    let priceSize = this.sizes[this.size].price;
    let price = priceStuffing + priceSize;

    this.selectedToppings.forEach(function (topping) {
      let priceTopping = this.toppings[topping].price;
      if (typeof priceTopping === "object") {
        price += priceTopping[this.size];
      } else {
        price += priceTopping;
      }
    }, this);
    return price;
  }

  calculateCalories() {
    let calories =
      this.stuffings[this.stuffing].calories + this.sizes[this.size].calories;
    this.selectedToppings.forEach(function (topping) {
      calories += this.toppings[topping].calories;
    }, this);
    return calories;
  }
}
