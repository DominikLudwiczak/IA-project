import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { TournamentDetails, TournamentsClientService } from 'projects/api-client/src';
import { AuthService } from '../services/auth.service';
import { MatDialog } from '@angular/material/dialog';
import { RegisterForTournamentComponent } from './register-for-tournament/register-for-tournament.component';
import { Location } from '@angular/common'
import { BehaviorSubject, Observable, Subject } from 'rxjs';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-tournament-details',
  templateUrl: './tournament-details.component.html',
  styleUrls: ['./tournament-details.component.sass']
})
export class TournamentDetailsComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";
  tournament: TournamentDetails;
  registerDeadline: Date = new Date();
  now: Date = new Date();
  link: any;

  constructor(private TournamentsClientService: TournamentsClientService,
              private AuthService: AuthService,
              private dialog: MatDialog,
              private route: ActivatedRoute,
              private sanitizer: DomSanitizer,
              private location: Location) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.getTournament(params['id']);
    });

    setInterval(() => {
      this.now = new Date();
    }, 1000);
  }

  getTournament(id: number) {
    this.loading = true;
    this.TournamentsClientService.tournamentById(id).subscribe((res: any) => {
      this.tournament = res.data;
      this.registerDeadline = new Date(this.tournament.registration_time);
      this.link = this.sanitizer.bypassSecurityTrustResourceUrl(`http://maps.google.com/maps?q=${this.tournament.latitude},${this.tournament.longitude}&z=13&output=embed`);
    }, err => {
      console.error(err);
    }).add(() => {
      this.loading = false;
    });
  }

  takePart() {
    this.dialog.open(RegisterForTournamentComponent, {
      data: {
        tournamentId: this.tournament.id,
        isLogged: this.AuthService.isLoggedIn.value
      }
    }).afterClosed().subscribe((alert: any) => {
      if(alert == undefined) return;
      this.showAlert = true;
      this.responseType = alert.type;
      this.responseMessage = alert.message;
    });
  }

  goBack() {
    this.location.back();
  }
}
