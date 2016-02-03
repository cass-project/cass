import angular from 'angular';

factory.$inject = ['$resource'];

function factory($resource) {
  return new SquareCalculateService($resource);
}

export class SquareCalculateService {
  constructor($resource) {
    this.api = $resource('/backend/api/square/calculate/:input');
  }

  getResult(input) {
    return this.api.get({
      input: input
    });
  }
}

angular.module('app').factory('SquareCalculateService', factory);