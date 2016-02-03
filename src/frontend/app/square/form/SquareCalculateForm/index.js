import angular from 'angular';

require('./style.scss');

function directive() {
  SquareCalculateForm.$inject = [
    'SquareCalculateService'
  ];

  return {
    restrict: 'E',
    template: require('./template.html'),
    controller: SquareCalculateForm,
    controllerAs: 'form'
  }
}

export class SquareCalculateForm {
  constructor(SquareCalculateService) {
    this.service = SquareCalculateService;
    this.input = 0;
    this.result = 0;
  }

  ngSubmit($event) {
    $event.preventDefault();

    this.service.api.get({input: this.input}, (data) => {
      this.result = data.result;
    });
  }
}

angular.module('app').directive('squareCalculateForm', directive);