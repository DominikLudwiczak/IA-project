import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { VerifyEmailClientService } from 'projects/api-client/src';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-confirm-email',
  templateUrl: './confirm-email.component.html',
  styleUrls: ['./confirm-email.component.sass']
})
export class ConfirmEmailComponent implements OnInit {
  loading: boolean = true;
  responseType: string = "";
  responseMessage: string = "";

  constructor(private route: ActivatedRoute,
              private authService: AuthService,
              private router: Router,
              private VerifyEmailClientService: VerifyEmailClientService) { }

  ngOnInit() {
    if(this.authService.isLoggedIn.value) {
      this.authService.setUser(this.authService.getToken()!);
      if(this.authService.loggedUser().isEmailVerified) {
        return this.goToApp();
      }
    }

    let queryParams = this.route.snapshot.queryParams;
    this.route.params.subscribe(params => {
      if(params['id'] === "0") {
        return this.resendEmailConfirmation();
      }
      if(!params['id'] || !queryParams['expires'] || !queryParams['hash'] || !queryParams['signature']) {
        this.responseType = "error";
        this.responseMessage = "Invalid request";
        this.loading = false;
        return;
      }
      this.VerifyEmailClientService.verifyEmail(params['id'], queryParams['expires'], queryParams['hash'], queryParams['signature']).subscribe(
        res => {
          this.responseType = "success";
          this.responseMessage = res.message;
        },
        err => {
          this.responseType = "error";
          this.responseMessage = err.error.message;
          this.loading = false;
        },
      ).add(() => {
        this.loading = false;
      });
    });
  }

  resendEmailConfirmation() {
    if(!this.authService.isLoggedIn.value) {
      this.responseMessage = "In order to resend the email confirmation, you must be logged in. Redirecting to login in 5 seconds...";
      setTimeout(() => {
        this.router.navigate(['/login']);
      }, 5000);
      return;
    }

    this.loading = true;
    this.VerifyEmailClientService.resendVerificationEmail().subscribe(
      res => {
        this.responseType = "success";
        this.responseMessage = res.message;
      },
      err => {
        this.responseType = "error";
        this.responseMessage = err.error.message;
      }
    ).add(() => {
      this.loading = false;
    });
  }

  goToApp() {
    this.loading = false;
    this.responseType = "success";
    this.responseMessage = "Redirecting to app in 5 seconds...";
    setTimeout(() => {
      this.router.navigate(['/']);
    }, 5000);
  }
}
