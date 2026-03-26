const factButton = document.getElementById('fact-spinner');
const challengeButton = document.getElementById('challenge-reroll');
const factItems = Array.from(document.querySelectorAll('.fact-item p'));
const challengeTitle = document.querySelector('#challenge h2');
const challengeText = document.querySelector('#challenge p');
const challengeReward = document.querySelector('.challenge-reward strong');

const factPool = [
  'Le brocoli est compose a plus de 85% d\'eau: parfait pour rester leger.',
  'Le brocoli aime la vapeur: cuisson courte = plus de vitamines conservees.',
  'Sa couleur verte vient de la chlorophylle, championne du mode nature.',
  'Il existe des varietes violettes, mais la team green reste iconique.'
];

const challengePool = [
  {
    title: 'Defi Sprint: Brocco Brain',
    description: 'Cite deux vitamines presentes dans le brocoli en 10 secondes.',
    reward: '+120 leaf points'
  },
  {
    title: 'Defi Duo: Green Combo',
    description: 'Associe le brocoli avec une source de proteines pour un repas smart.',
    reward: '+150 leaf points'
  },
  {
    title: 'Defi Expert: Myth Buster',
    description: 'Explique pourquoi le brocoli n\'est pas juste un legume "diet".',
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
