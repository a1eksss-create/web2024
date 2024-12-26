// задание 3

function spinWords(str) {
  let words = str.split(" ");
  let result = [];

  for (let i = 0; i < words.length; i++) {
    let word = words[i];

    if (word.length >= 5) {
      word = word.split("").reverse().join("");
    }
    result.push(word);
  }

  return result.join(" ");
}

const result1 = spinWords("Привет от Legacy");
console.log(result1);

const result2 = spinWords("This is a test");
console.log(result2);
