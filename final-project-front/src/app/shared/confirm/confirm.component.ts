import { Component } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-confirm',
  templateUrl: './confirm.component.html',
  styleUrls: ['./confirm.component.sass']
})
export class ConfirmComponent {
  constructor(private dialogRef: MatDialogRef<ConfirmComponent>) { }

  confirm() {
    this.dialogRef.close(true);
  }

  close() {
    this.dialogRef.close();
  }
}
