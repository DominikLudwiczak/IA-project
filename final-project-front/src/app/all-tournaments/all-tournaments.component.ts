import { Component, OnInit } from '@angular/core';
import { TournamentsClientService } from 'projects/api-client/src/api/tournaments.service';
import { Tournament } from 'projects/api-client/src/model/tournament';

@Component({
  selector: 'app-all-tournaments',
  templateUrl: './all-tournaments.component.html',
  styleUrls: ['./all-tournaments.component.sass']
})
export class AllTournamentsComponent implements OnInit {
    loading = false;
    displayedColumns: string[] = ['index', 'name', 'time', 'registration_time', 'max_participants', 'actions'];
    dataSource: Tournament[] = [];
    paginationResponse: any;
    filter: string;

    constructor(private TournamentsClientService: TournamentsClientService) { }

    ngOnInit(): void {
      this.getTournaments();
    }

    getTournaments(page: number = 1) {
      this.loading = true;
      this.TournamentsClientService.allTournaments(page=page, this.filter).subscribe((res: any) => {
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
