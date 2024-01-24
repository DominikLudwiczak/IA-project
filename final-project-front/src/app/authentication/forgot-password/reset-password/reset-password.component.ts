import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { PasswordClientService, ResetPasswordStoreRequest } from 'projects/api-client/src';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.sass']
})
export class ResetPasswordComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";

  public resetPasswordForm: FormGroup = new FormGroup({
    token: new FormControl('', Validators.required),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required),
    password_confirmation: new FormControl('', Validators.required),
  });

  constructor(private route: ActivatedRoute,
              private router: Router,
              private PasswordClientService: PasswordClientService) {}

  ngOnInit(): void {
    let queryParams = this.route.snapshot.queryParams;
    if(!queryParams['token'] || !queryParams['email']) {
      this.resetPasswordForm.disable();
      this.responseType = "error";
      this.responseMessage = "Invalid request";
      this.showAlert = true;
    }

    this.resetPasswordForm.patchValue({
      token: queryParams['token'],
      email: queryParams['email']
    });
    this.resetPasswordForm.get('token')?.disable();
    this.resetPasswordForm.get('email')?.disable();
  }

  public isFormValid(): boolean {
    return this.resetPasswordForm.valid;
  }

  send() {
    this.loading = true;
    let resetPasswordStoreRequest: ResetPasswordStoreRequest = {
      token: this.resetPasswordForm.get('token')?.value,
      email: this.resetPasswordForm.get('email')?.value,
      password: this.resetPasswordForm.get('password')?.value,
      password_confirmation: this.resetPasswordForm.get('password_confirmation')?.value,
    };

    this.PasswordClientService.resetPasswordStore(resetPasswordStoreRequest).subscribe(
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

  goToLogin() {
    this.router.navigate(['/login']);
  }
}
