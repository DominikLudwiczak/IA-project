import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AuthenticationClientService, RegisterRequest } from 'projects/api-client/src';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.sass']
})
export class RegisterComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";

  public registerForm: FormGroup = new FormGroup({
    firstName: new FormControl('', Validators.required),
    lastName: new FormControl('', Validators.required),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required)
  });

  constructor (private AuthClientService: AuthenticationClientService) { }

  ngOnInit(): void {

  }

  public isFormValid(): boolean {
    return this.registerForm.valid;
  }

  send() {
    this.loading = true;
    this.AuthClientService.register(this.registerForm.value as RegisterRequest).subscribe(
      (res) => {
       this.registerForm.reset();
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
