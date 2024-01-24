import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NoAuthGuardService } from './auth/no-auth-guard.service';
import { LoginComponent } from './authentication/login/login.component';
import { AuthGuardService } from './auth/auth-guard.service';
import { DashboardComponent } from './dashboard/dashboard.component';
import { RegisterComponent } from './authentication/register/register.component';
import { ForgotPasswordComponent } from './authentication/forgot-password/forgot-password.component';
import { ResetPasswordComponent } from './authentication/forgot-password/reset-password/reset-password.component';
import { ChangePasswordComponent } from './authentication/change-password/change-password.component';
import { ConfirmEmailComponent } from './authentication/confirm-email/confirm-email.component';
import { EmailVerifiedGuardService } from './auth/email-verified-guard.service';
import { AllTournamentsComponent } from './all-tournaments/all-tournaments.component';
import { UserTournamentsComponent } from './user-tournaments/user-tournaments.component';
import { AddEditTournamentComponent } from './user-tournaments/add-edit-tournament/add-edit-tournament.component';
import { TournamentDetailsComponent } from './tournament-details/tournament-details.component';

const routes: Routes = [
  {
    path: '', canActivate: [NoAuthGuardService], children: [
      { path: '', component: LoginComponent },
      { path: 'login', component: LoginComponent },
      { path: 'register', component: RegisterComponent },
      { path: 'forgot-password', component: ForgotPasswordComponent },
      { path: 'reset-password', component: ResetPasswordComponent },
    ]
  },
  { path: 'confirm-email/:id', component: ConfirmEmailComponent },
  {
    path: '', component: DashboardComponent, children: [
      { path: 'tournaments', component: AllTournamentsComponent },
      { path: 'tournaments/:id', component: TournamentDetailsComponent },
    ]
  },
  {
    path: 'app', canActivate: [AuthGuardService, EmailVerifiedGuardService], component: DashboardComponent, children: [
      { path: 'tournaments', component: UserTournamentsComponent },
      { path: 'tournaments/add', component: AddEditTournamentComponent },
      { path: 'tournaments/edit/:id', component: AddEditTournamentComponent },
      {
        path: 'settings', children: [
          { path: 'change-password', component: ChangePasswordComponent },
        ]
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { useHash: false })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
