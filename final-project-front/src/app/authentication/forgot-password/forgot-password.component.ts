import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { PasswordClientService, ResetPasswordRequest } from 'projects/api-client/src';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.sass']
})
export class ForgotPasswordComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";

  public resetPasswordForm: FormGroup = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
  });
  
  constructor(private PasswordClientService: PasswordClientService) {}

  ngOnInit(): void {
    
  }

  public isFormValid(): boolean {
    return this.resetPasswordForm.valid;
  }

  send() {
    this.loading = true;
    this.PasswordClientService.resetPassword(this.resetPasswordForm.value as ResetPasswordRequest).subscribe(
      (res) => {
        this.resetPasswordForm.reset();
        this.responseType = "success";
        this.responseMessage = res.message;
      },
      (err) => {
        this.responseType = "error";
        this.responseMessage = err.error.message;
      }
    ).add(() => {
      this.showAlert = true;
      this.loading = false;
    });
  }
}
