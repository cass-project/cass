routes.$inject = ['$stateProvider'];

export default function routes($stateProvider) {
  $stateProvider
    .state('square.home', {
      url: '/home',
      template: require('./template.html'),
      controller: 'SquareCenterComponent',
      controllerAs: 'squareCenter'
    })
  ;
}