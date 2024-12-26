// задание 4

function twoSum(nums, target) {
  const numMap = {};

  for (let i = 0; i < nums.length; i++) {
    const compl = target - nums[i];

    if (numMap.hasOwnProperty(compl)) {
      return [numMap[compl], i];
    }
    numMap[nums[i]] = i;
  }
  return null;
}

const nums = [2, 7, 11, 15];
const target = 9;
let result_4 = twoSum(nums, target);
console.log(result_4); // [0, 1]
