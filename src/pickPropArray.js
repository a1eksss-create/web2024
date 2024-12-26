// задание 1

function pickPropArray(array, property) {
  let result = [];

  for (let obj of array) {
    if (obj.hasOwnProperty(property)) {
      result.push(obj[property]);
    }
  }
  return result;
}

let students = [
  { name: "Павел", age: 20 },
  { name: "Иван", age: 20 },
  { name: "Эдем", age: 20 },
  { name: "Денис", age: 20 },
  { name: "Виктория", age: 20 },
  { age: 40 },
];

let result_1 = pickPropArray(students, "name");

console.log(result_1);
