import { Component, OnInit } from '@angular/core';
import { Tournament, TournamentsClientService } from 'projects/api-client/src';

@Component({
  selector: 'app-user-tournaments',
  templateUrl: './user-tournaments.component.html',
  styleUrls: ['./user-tournaments.component.sass']
})
export class UserTournamentsComponent implements OnInit {
  loading: boolean = false;
  displayedColumns: string[] = ['index', 'name', 'time', 'registration_time', 'max_participants', 'discipline_id', 'actions'];
  dataSource: Tournament[] = [];
  paginationResponse: any;

  constructor(private TournamentsClientService: TournamentsClientService) { }

  ngOnInit(): void {
    this.getTournaments();
  }

  getTournaments(page: number = 1) {
    this.loading = true;
    this.TournamentsClientService.allTournaments(page=page).subscribe((res: any) => {
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
}
