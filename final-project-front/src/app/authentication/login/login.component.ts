import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { LoginRequest } from 'projects/api-client/src/model/loginRequest';
import { AuthService } from 'src/app/services/auth.service';

const loginErrorTimeoutSec: number = 3;
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass']
})
export class LoginComponent implements OnInit{
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";

  public loginForm: FormGroup = new FormGroup({
    login: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required)
  });

  constructor(private router: Router, private auth: AuthService) { }

  ngOnInit(): void { }

  public onSubmit() {
    this.loading = true;

    const requestedUser: LoginRequest = { email: this.loginForm.value.login, password: this.loginForm.value.password }
    this.auth.loginUser(
      requestedUser,
      () => {
        this.loading = false;
        this.router.navigate(['/app']);
      },
      () => {
        this.loading = false;
        this.showAlert = true;
        this.responseType = "error";
        this.responseMessage = "Invalid login or password";
      });
  }

  public isFormValid(): boolean {
    return this.loginForm.valid;
  }
}
