import { Component, OnInit } from '@angular/core';
import { Tournament, TournamentsClientService } from 'projects/api-client/src';

@Component({
  selector: 'app-participating-tournaments',
  templateUrl: './participating-tournaments.component.html',
  styleUrls: ['./participating-tournaments.component.sass']
})
export class ParticipatingTournamentsComponent implements OnInit {
  loading: boolean = false;
  displayedColumns: string[] = ['index', 'name', 'time', 'registration_time', 'max_participants', 'actions'];
  dataSource: Tournament[] = [];
  paginationResponse: any;
  now = new Date();

  constructor(private TournamentsClientService: TournamentsClientService) { }

  ngOnInit(): void {
    this.getTournaments();
    setInterval(() => {
      this.now = new Date();
    }, 1000);
  }

  getTournaments(page: number = 1) {
    this.loading = true;
    this.TournamentsClientService.allTournamentsParticipating(page=page).subscribe((res: any) => {
      this.paginationResponse = res.data;
      this.dataSource = this.paginationResponse.data as Tournament[];
    }, err => {
      console.error(err);
    }).add(() => {
      this.loading = false;
    });
  }

  pageChanged(event: any) {
    this.getTournaments(event.pageIndex+1);
  }

  getDate(date: string) {
    return new Date(date);
  }
}
