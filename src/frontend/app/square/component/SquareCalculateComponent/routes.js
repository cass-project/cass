routes.$inject = ['$stateProvider'];

export default function routes($stateProvider) {
  $stateProvider
    .state('square.calculate', {
      url: '/calculate',
      template: require('./template.html'),
      controller: 'SquareCalculateComponent',
      controllerAs: 'squareCalculate'
    })
  ;
}