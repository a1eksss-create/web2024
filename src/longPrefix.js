// задание 5

function longPrefix(arr) {
  if (arr.length < 2) return "";

  const prefix = (str1, str2) => {
    let i = 0;
    while (
      i < str1.length &&
      i < str2.length &&
      str1[str1.length - 1 - i] === str2[str2.length - 1 - i]
    ) {
      i++;
    }
    return str1.slice(str1.length - i);
  };

  let resPrefix = arr[0];
  for (let i = 1; i < arr.length; i++) {
    resPrefix = prefix(resPrefix, arr[i]);
    if (resPrefix.length < 2) return "";
  }
  return resPrefix;
}

const strs1 = ["цветок", "поток", "хлопок"];
console.log(longPrefix(strs1));

const strs2 = ["собака", "гоночная машина", "машина"];
console.log(longPrefix(strs2));
