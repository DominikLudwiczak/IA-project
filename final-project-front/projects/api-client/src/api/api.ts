export * from './authentication.service';
import { AuthenticationClientService } from './authentication.service';
export * from './disciplines.service';
import { DisciplinesClientService } from './disciplines.service';
export * from './ladder.service';
import { LadderClientService } from './ladder.service';
export * from './password.service';
import { PasswordClientService } from './password.service';
export * from './tournaments.service';
import { TournamentsClientService } from './tournaments.service';
export * from './verifyEmail.service';
import { VerifyEmailClientService } from './verifyEmail.service';
export const APIS = [AuthenticationClientService, DisciplinesClientService, LadderClientService, PasswordClientService, TournamentsClientService, VerifyEmailClientService];
