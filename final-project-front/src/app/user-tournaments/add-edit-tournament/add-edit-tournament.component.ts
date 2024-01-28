import { DatePipe, Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { ActivatedRoute } from '@angular/router';
import { load } from 'mime';
import { Discipline, TournamentRequest, TournamentsClientService } from 'projects/api-client/src';
import { DisciplinesClientService } from 'projects/api-client/src/api/disciplines.service';
import { ConfirmComponent } from 'src/app/shared/confirm/confirm.component';

@Component({
  selector: 'app-add-edit-tournament',
  templateUrl: './add-edit-tournament.component.html',
  styleUrls: ['./add-edit-tournament.component.sass']
})
export class AddEditTournamentComponent implements OnInit {
  loading: boolean = false;
  showAlert: boolean = false;
  responseType: string = "";
  responseMessage: string = "";
  tournamentId: number;
  inEditMode: boolean = false;
  disciplines: Discipline[];

  today = new Date(); 
  date: Date;
  time: string;
  regDate: Date;
  regTime: string;

  tournamentForm: FormGroup = new FormGroup({
    name: new FormControl('', [Validators.required]),
    time: new FormControl('', [Validators.required]),
    registration_time: new FormControl('', [Validators.required]),
    max_participants: new FormControl('', [Validators.required]),
    discipline_id: new FormControl('', [Validators.required]),
    latitude: new FormControl('', [Validators.required]),
    longitude: new FormControl('', [Validators.required]),
  });

  constructor(private datepipe: DatePipe,
              private location: Location,
              private route: ActivatedRoute,
              private dialog: MatDialog,
              private TournamentsClientService: TournamentsClientService,
              private DisciplinesClientService: DisciplinesClientService)
            {
              this.route.params.subscribe(params => {
                if(params['id'] != undefined) {
                  this.inEditMode = true;
                  this.tournamentId = params['id'];
                }
              });
            }

  ngOnInit(): void {
    this.getDisciplines();
    if(this.inEditMode)
    {
      this.getTournament();
    }
  }

  goBack() {
    this.location.back();
  }

  getDisciplines() {
    this.loading = true;
    this.DisciplinesClientService.allDisciplines().subscribe((res: any) => {
      this.disciplines = res.data as Discipline[];
    }, err => {
      this.showAlert = true;
      this.responseType = "error";
      this.responseMessage = "Something went wrong. Please try again later.";
    }).add(() => {
      this.loading = false;
    });
  }

  getTournament() {
    this.loading = true;
    this.TournamentsClientService.tournamentById(this.tournamentId).subscribe((res: any) => {
      this.tournamentForm.patchValue(res.data);
      this.date = new Date(res.data.time);
      this.time = this.datepipe.transform(this.date, 'HH:mm')!;
      this.regDate = new Date(res.data.registration_time);
      this.regTime = this.datepipe.transform(this.regDate, 'HH:mm')!;
      this.changeDateTime();
      this.changeDateTime(true);
    }, err => {
      this.showAlert = true;
      this.responseType = "error";
      this.responseMessage = "Something went wrong. Please try again later.";
    }).add(() => {
      this.loading = false;
    });
  }

  changeDateTime(registration: boolean = false) {
    if(registration) {
      this.tournamentForm.patchValue({
        registration_time: `${this.datepipe.transform(this.regDate, 'yyyy-MM-dd')} ${this.regTime}`
      });
    } else {
      this.tournamentForm.patchValue({
        time: `${this.datepipe.transform(this.date, 'yyyy-MM-dd')} ${this.time}`
      });
    }
  }

  send() {
    this.loading = true;
    if(this.inEditMode)
    {
      this.dialog.open(ConfirmComponent).afterClosed().subscribe(result => {
        if(result) {
          this.TournamentsClientService.editTournament(this.tournamentId, this.tournamentForm.value as TournamentRequest).subscribe((res: any) => {
            this.responseType = "success";
            this.responseMessage = res.message;
          }, err => {
            this.responseType = "error";
            this.responseMessage = err.error.message;
          }).add(() => {
            this.showAlert = true;
            this.loading = false;
          });
        } else {
          this.loading = false;
        }
      });
    } 
    else
    {
      this.TournamentsClientService.createTournament(this.tournamentForm.value as TournamentRequest).subscribe((res: any) => {
        this.responseType = "success";
        this.responseMessage = res.message;
        this.tournamentForm.reset();
      }, err => {
        this.responseType = "error";
        this.responseMessage = err.error.message;
      }).add(() => {
        this.showAlert = true;
        this.loading = false;
      });
    }
  }
}
