require('./style.scss');

import angular from 'angular';
import routing from './routes';

import SquareHomeComponent from './../SquareHomeComponent';
import SquareCalculateComponent from './../SquareCalculateComponent';

export class SquareCenterComponent
{
  constructor() {}
}

angular.module('app')
  .config(routing)
  .controller('SquareCenterComponent', SquareCenterComponent)
;
