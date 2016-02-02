import angular from "angular";
import uirouter from 'angular-ui-router';
import routing from './routing';

export default angular
  .module('app', ['ui.router'])
  .config(routing)
  .run(['$rootScope', '$state', function($rootScope, $state) {
    $rootScope.$on('$stateChangeStart', function(evt, to, params) {
      if (to.redirectTo) {
        evt.preventDefault();
        $state.go(to.redirectTo, params)
      }
    });
  }])
  .name
;