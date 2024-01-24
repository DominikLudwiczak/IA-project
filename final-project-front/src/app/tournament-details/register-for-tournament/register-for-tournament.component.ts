import { Component, EventEmitter, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { Router } from '@angular/router';
import { RegisterForTournamentRequest, TournamentsClientService } from 'projects/api-client/src';

@Component({
  selector: 'app-register-for-tournament',
  templateUrl: './register-for-tournament.component.html',
  styleUrls: ['./register-for-tournament.component.sass']
})
export class RegisterForTournamentComponent {
  loading: boolean = false;
  tournamentId: number;
  isLogged: boolean;
  alert: any = new EventEmitter<any>();

  registerRequest: FormGroup = new FormGroup({
    rank: new FormControl('', [Validators.required, Validators.min(1)]),
    license: new FormControl('', [Validators.required]),
  });

  constructor(private dialogRef: MatDialogRef<RegisterForTournamentComponent>,
              @Inject(MAT_DIALOG_DATA) private data: {
                tournamentId: number,
                isLogged: boolean
              },
              private TournamentsClientService: TournamentsClientService,
              private router: Router) 
              {
                  this.tournamentId = data.tournamentId;
                  this.isLogged = data.isLogged;

                  this.router.events
                  .subscribe(() => {
                    dialogRef.close();
                  });
              }

  register() {
    this.loading = true;
    this.TournamentsClientService.registerForTournament(this.tournamentId, this.registerRequest.value as RegisterForTournamentRequest).subscribe((res: any) => {
      this.alert = {type: "success", message: res.message};
    }, err => {
      this.alert = {type: "error", message: err.error.message};
    }).add(() => {
      this.loading = false;
      this.dialogRef.close(this.alert);
    });
  }

  close() {
    this.dialogRef.close();
  }
}
