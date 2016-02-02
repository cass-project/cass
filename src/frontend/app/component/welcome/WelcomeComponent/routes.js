routes.$inject = ['$stateProvider'];

export default function routes($stateProvider) {
  $stateProvider
    .state('welcome', {
      url: '/',
      template: require('./template.html'),
      controller: 'WelcomeComponent',
      controllerAs: 'welcome'
    })
  ;
}