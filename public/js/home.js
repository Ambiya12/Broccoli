const factButton = document.getElementById('fact-spinner');
const challengeButton = document.getElementById('challenge-reroll');
const factItems = Array.from(document.querySelectorAll('.fact-item p'));
const challengeTitle = document.querySelector('#challenge h2');
const challengeText = document.querySelector('#challenge p');
const challengeReward = document.querySelector('.challenge-reward strong');

const factPool = [
  'Broccoli is more than 85% water: perfect for staying light and fresh.',
  'Broccoli loves steaming: short cooking = more vitamins preserved.',
  'Its green color comes from chlorophyll, nature\'s champion.',
  'Purple broccoli varieties exist, but the green team stays iconic.'
];

const challengePool = [
  {
    title: 'Sprint Challenge: Broccoli Brain',
    description: 'Name two vitamins in broccoli in 10 seconds.',
    reward: '+120 leaf points'
  },
  {
    title: 'Duo Challenge: Green Combo',
    description: 'Pair broccoli with a protein source for a smart meal.',
    reward: '+150 leaf points'
  },
  {
    title: 'Expert Challenge: Myth Buster',
    description: 'Explain why broccoli is not just a "diet" vegetable.',
    reward: '+180 leaf points'
  }
];

function randomItem(list) {
  return list[Math.floor(Math.random() * list.length)];
}

if (factButton && factItems.length > 0) {
  factButton.addEventListener('click', () => {
    const randomFact = randomItem(factPool);
    factItems[0].textContent = randomFact;
    factItems[0].parentElement.classList.add('is-highlighted');
    window.setTimeout(() => {
      factItems[0].parentElement.classList.remove('is-highlighted');
    }, 450);
  });
}

if (challengeButton && challengeTitle && challengeText && challengeReward) {
  challengeButton.addEventListener('click', () => {
    const challenge = randomItem(challengePool);
    challengeTitle.textContent = challenge.title;
    challengeText.textContent = challenge.description;
    challengeReward.textContent = challenge.reward;
  });
}
