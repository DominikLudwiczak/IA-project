import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.sass']
})
export class AlertComponent implements OnInit  {
  @Input() type: string = "";
  @Input() message: string = "";
  @Output() isOpened = new EventEmitter<boolean>();

  alertDuration: number = 5;

  constructor() { }

  ngOnInit(): void {
    setTimeout(() => {
      this.isOpened.emit(false);
    }, this.alertDuration * 1000);
  }
}
