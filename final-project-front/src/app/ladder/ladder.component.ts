import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { LadderClientService } from 'projects/api-client/src/api/ladder.service';
import { Ladder } from 'projects/api-client/src/model/ladder';
import { AuthService } from '../services/auth.service';
import { Tournament } from 'projects/api-client/src';
import { User } from 'projects/api-client/src/model/user';
import { MatDialog } from '@angular/material/dialog';
import { RateGameComponent } from './rate-game/rate-game.component';

@Component({
  selector: 'app-ladder',
  templateUrl: './ladder.component.html',
  styleUrls: ['./ladder.component.sass']
})
export class LadderComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";
  tournamentId: number;
  ladder: LadderGame[] = [];
  userEmail: string;

  constructor(private route: ActivatedRoute,
              private AuthService: AuthService,
              private dialog: MatDialog,
              private LadderClientService: LadderClientService) { }

  ngOnInit() {
    this.route.params.subscribe(params => {
      this.tournamentId = params['id'];
      this.getLadder();
    });
    this.userEmail = this.AuthService.loggedUser().email;
  }

  getLadder() {
    this.LadderClientService.ladderForTournament(this.tournamentId).subscribe((res: any) => {
      this.ladder = [];
      res.data.forEach((game: Ladder) => {
        let ladder = {
          id: game.id,
          tournament: game.tournament,
          participant1: game.participant1,
          participant2: game.participant2,
          winner_id: game.winner_id,
          can_edit: game.participant1.email == this.userEmail || game.participant2.email == this.userEmail
        } as LadderGame;
        this.ladder.push(ladder);
      });
    }, err => {
      console.error(err);
    }).add(() => {
      this.loading = false;
    });
  }

  rate(ladder: LadderGame) {
    if(ladder.can_edit && ladder.winner_id == null) {
      this.dialog.open(RateGameComponent, {
        data: {
          ladder: ladder,
        }
      }).afterClosed().subscribe((alert: any) => {
        if(alert == undefined) return;
        this.showAlert = true;
        this.responseType = alert.type;
        this.responseMessage = alert.message;
        this.getLadder();
      });
    }
  }
}

export class LadderGame implements Ladder{
  id: number;
  tournament: Tournament;
  participant1: User;
  participant2: User;
  winner_id: number;
  can_edit: boolean;
}
