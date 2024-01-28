import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { BASE_PATH } from 'projects/api-client/src';
import { AuthService } from './services/auth.service';
import { AddHeaderInterceptor } from './interceptors/ad-header-interceptor';
import { LoginComponent } from './authentication/login/login.component';
import { RegisterComponent } from './authentication/register/register.component';
import { SharedModule } from './shared/shared.module';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ConfirmEmailComponent } from './authentication/confirm-email/confirm-email.component';
import { ForgotPasswordComponent } from './authentication/forgot-password/forgot-password.component';
import { ChangePasswordComponent } from './authentication/change-password/change-password.component';
import { ResetPasswordComponent } from './authentication/forgot-password/reset-password/reset-password.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MaterialsModule } from './materials/materials.module';
import { SidenavComponent } from './navigation/sidenav/sidenav.component';
import { NavbarComponent } from './navigation/navbar/navbar.component';
import { AllTournamentsComponent } from './all-tournaments/all-tournaments.component';
import { UserTournamentsComponent } from './user-tournaments/user-tournaments.component';
import { AddEditTournamentComponent } from './user-tournaments/add-edit-tournament/add-edit-tournament.component';
import { NotLoginNavbarComponent } from './navigation/not-login-navbar/not-login-navbar.component';
import { TournamentDetailsComponent } from './tournament-details/tournament-details.component';
import { RegisterForTournamentComponent } from './tournament-details/register-for-tournament/register-for-tournament.component';
import { ParticipatingTournamentsComponent } from './participating-tournaments/participating-tournaments.component';
import { LadderComponent } from './ladder/ladder.component';
import { RateGameComponent } from './ladder/rate-game/rate-game.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    DashboardComponent,
    ConfirmEmailComponent,
    ForgotPasswordComponent,
    ChangePasswordComponent,
    ResetPasswordComponent,
    SidenavComponent,
    NavbarComponent,
    AllTournamentsComponent,
    UserTournamentsComponent,
    AddEditTournamentComponent,
    NotLoginNavbarComponent,
    TournamentDetailsComponent,
    RegisterForTournamentComponent,
    ParticipatingTournamentsComponent,
    LadderComponent,
    RateGameComponent,
  ],
  imports: [
    AppRoutingModule,
    SharedModule,
    BrowserAnimationsModule,
    MaterialsModule
  ],
  providers: [{
    provide: HTTP_INTERCEPTORS,
    useClass: AddHeaderInterceptor,
    multi: true,
    deps: [AuthService]
  },
  {
    provide: BASE_PATH,
    useValue: environment.apiBasePath
  }],
  bootstrap: [AppComponent]
})
export class AppModule { }
