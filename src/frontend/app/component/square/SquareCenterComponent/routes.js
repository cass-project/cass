routes.$inject = ['$stateProvider'];

export default function routes($stateProvider) {
  $stateProvider
    .state('square', {
      url: '/square',
      template: require('./template.html'),
      controller: 'SquareCenterComponent',
      controllerAs: 'squareCenter',
      redirectTo: 'square.home'
    })
  ;
}