#define _CRT_SECURE_NO_WARNINGS
#include <windows.h>
#include "resource.h"
#include <iostream>
#include "strsafe.h"


#define ID_LISTL 502
#define ID_LISTR 503
#define ID_ToRight 1001
#define ID_ToLeft 1002
#define ID_SETTINGS 1003

LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam);
//BOOL WINAPI DlgDirSelect(HWND hWnd, LPSTR lpszBuffer, int idListBox);

struct Text_Set {
	TCHAR TEXT[1024];
	COLORREF TextColor = NULL;
	COLORREF BGColor = NULL;
	int orientation = 0;
};

HINSTANCE hInst; 
HWND hListL;
HWND hListR;
char ClassName[] = "Window"; 		
char AppTitle[] = "CGW"; 	
TCHAR tempText[1024];
Text_Set str;
COLORREF colClndr;
RECT rect = { 0, 0, 0, 0 };


int WINAPI WinMain(HINSTANCE hInstance,HINSTANCE hPrevInstance, LPSTR lpCmdLine,int nCmdShow)
{
	WNDCLASS wc; 	
	HWND hWnd; 	
		

	MSG msg; 	

	hInst = hInstance;

	
	if ((hWnd = FindWindow(ClassName, NULL)) != NULL)
	{
		
		if (IsIconic(hWnd)) ShowWindow(hWnd, SW_RESTORE);
		SetForegroundWindow(hWnd);

	
		return FALSE;
	}

	
	memset(&wc, 0, sizeof(wc));
	wc.lpszClassName = ClassName;		
	wc.lpfnWndProc = (WNDPROC)WndProc;
	
	wc.style = CS_HREDRAW | CS_VREDRAW;	 
	wc.hInstance = hInstance;		
	wc.hIcon = LoadIcon(NULL, IDI_APPLICATION);
	
	wc.hCursor = LoadCursor(NULL, IDC_ARROW);

	wc.hbrBackground = (HBRUSH)GetStockObject(WHITE_BRUSH);

	wc.lpszMenuName = NULL;		
	wc.cbClsExtra = 0;			
	wc.cbWndExtra = 0;			
	
	RegisterClass(&wc);

	
	hWnd = CreateWindow(
		ClassName, 		
		AppTitle,			
		WS_OVERLAPPEDWINDOW, 		
		CW_USEDEFAULT,			
		CW_USEDEFAULT,			
		CW_USEDEFAULT,			
		CW_USEDEFAULT,			
		NULL,		
		NULL,		
		hInst,		
		NULL);		
	if (!hWnd)
	{
		
		MessageBox(NULL,
			"Create: error", AppTitle, MB_OK | MB_ICONSTOP);
		return FALSE;
	}

	
	ShowWindow(hWnd, nCmdShow);

	
	UpdateWindow(hWnd);

	
	while (GetMessage(&msg, NULL, 0, 0))
	{
		
		TranslateMessage(&msg);
		
		DispatchMessage(&msg);
	}

	return msg.wParam;
}

void col(HWND hwnd)
{
	CHOOSECOLOR ch_color = { 0 };
	COLORREF cust_colors[16] = { 0 };
	ch_color.Flags = CC_FULLOPEN | CC_RGBINIT ;
	ch_color.lStructSize = sizeof(CHOOSECOLOR);
	
	ch_color.hwndOwner = hwnd;
	
	ch_color.lpCustColors = cust_colors;
	if (ChooseColor(&ch_color))
	{
		colClndr = ch_color.rgbResult;
	}
	
}


INT_PTR CALLBACK SetDLG(HWND hDlg, UINT msg, WPARAM wParam, LPARAM lParam)
{
	
	int k=0;
	HWND List = GetDlgItem(hDlg, IDC_ORIENTATION);
	switch (msg)
	{
		
	case WM_INITDIALOG:
	{
		
		SendMessage(List, LB_ADDSTRING, 0, (LPARAM)(LPSTR)"По вертикали");
		SendMessage(List, LB_ADDSTRING, 0, (LPARAM)(LPSTR)"По горизонтали");
		

		SetDlgItemText(hDlg, IDC_Text, str.TEXT);

		_itoa_s(str.TextColor, tempText, 10);
		SetDlgItemText(hDlg, IDC_TextCode, tempText);

		_itoa_s(str.BGColor, tempText, 10);
		SetDlgItemText(hDlg, IDC_BGCode, tempText);

		if (str.orientation == 0)
		{
			SendMessage(List, LB_SETCURSEL, 1, 0L);
		}
		else
		{
			SendMessage(List, LB_SETCURSEL, 0, 0L);
		}

		return TRUE;
	};

		

	case WM_COMMAND:
		switch (LOWORD(wParam))
		{
		
		case IDOK:
			{
				GetDlgItemText(hDlg, IDC_Text, str.TEXT, 1024);

				GetDlgItemText(hDlg, IDC_TextCode, tempText, 10);
				str.TextColor = atoi(tempText);

				GetDlgItemText(hDlg, IDC_BGCode, tempText, 10);
				str.BGColor = atoi(tempText);

				 
				
				// Определяем номер выделенной строки
				if ((k = SendMessage(List, LB_GETCURSEL, 0, 0L)) != LB_ERR)
				{
					// Получаем выделенную строку
					SendMessage(List, LB_GETTEXT, k, (LPARAM)tempText);
					
				}

				if (!strcmp(tempText, "По горизонтали") )
					str.orientation = 0;
				else if(!strcmp(tempText, "По вертикали"))
					str.orientation = 1;

				EndDialog(hDlg, IDOK);
				return TRUE;
			};
			

		case IDCANCEL: {
				EndDialog(hDlg, IDCANCEL);
				return TRUE;
			}
		case IDC_TEXTCOLOR:
			{
				col(hDlg);
				str.TextColor = colClndr;
				_itoa_s(str.TextColor, tempText, 10);
				SetDlgItemText(hDlg, IDC_TextCode, tempText);
				return TRUE;
			};
			
		case IDC_BGCOLOR:
			{
				col(hDlg);
				str.BGColor = colClndr;
				_itoa_s(str.BGColor, tempText, 10);
				SetDlgItemText(hDlg, IDC_BGCode, tempText);
				return TRUE;
			};
			


		}
	}
	return FALSE;
}

LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam)
{
	int num;

	switch (msg)
	{
		case WM_CREATE:
		{
			hListL = CreateWindow("listbox", NULL, WS_CHILD | WS_VISIBLE | LBS_STANDARD, 30, 30, 200, 100, hWnd, (HMENU)ID_LISTL, hInst, NULL);
			SendMessage(hListL, WM_SETREDRAW, FALSE, 0L);

			SendMessage(hListL, LB_ADDSTRING, 0, (LPARAM)(LPSTR)"Первый");
			SendMessage(hListL, LB_ADDSTRING, 0, (LPARAM)(LPSTR)"Второй");
			SendMessage(hListL, LB_ADDSTRING, 0, (LPARAM)(LPSTR)"Третий");
			SendMessage(hListL, WM_SETREDRAW, TRUE, 0L);


			hListR = CreateWindow("listbox", NULL, WS_CHILD | WS_VISIBLE | LBS_STANDARD, 350, 30, 200, 100, hWnd, (HMENU)ID_LISTR, hInst, NULL);
			SendMessage(hListR, WM_SETREDRAW, TRUE, 0L);

			HWND ToRight = CreateWindow("BUTTON", "Переместить»", WS_CHILD | WS_VISIBLE, 240, 40, 100, 30, hWnd, (HMENU)ID_ToRight, hInst, NULL);
			HWND ToLeft = CreateWindow("BUTTON", "«Переместить", WS_CHILD | WS_VISIBLE, 240, 80, 100, 30, hWnd, (HMENU)ID_ToLeft, hInst, NULL);

			HWND TextBtn = CreateWindow("BUTTON", "Настроить", WS_CHILD | WS_VISIBLE, 600, 30, 100, 30, hWnd, (HMENU)ID_SETTINGS, hInst, NULL);
		};
			break;

		case WM_COMMAND:
		{
			switch (LOWORD(wParam))
			{
				case ID_SETTINGS: {
					int iCode = DialogBox(hInst, MAKEINTRESOURCE(DLG_SET), hWnd, SetDLG);
					if (iCode == IDOK)
					{
						
						InvalidateRect(hWnd, 0, TRUE);
						UpdateWindow(hWnd);
						
					}
				};
					break;
				case ID_ToRight:
				{
					// Определяем номер выделенной строки
					if ((num = SendMessage(hListL, LB_GETCURSEL, 0, 0L) )!= LB_ERR)
					{
						// Получаем выделенную строку
						SendMessage(hListL, LB_GETTEXT, num, (LPARAM)tempText);
						//Добавляем строку в правый список
						SendMessage(hListR, LB_ADDSTRING, 0, (LPARAM)(LPSTR)tempText);
						//Удаляем строку из левого списка
						SendMessage(hListL, LB_DELETESTRING, num, (LPARAM)(LPSTR)tempText);
					}
				};
				break;
				case ID_ToLeft: 
				{
					// Определяем номер выделенной строки
					if ((num = SendMessage(hListR, LB_GETCURSEL, 0, 0L)) != LB_ERR)
					{
						// Получаем выделенную строку
						SendMessage(hListR, LB_GETTEXT, num, (LPARAM)tempText);
						//Добавляем строку в левый список
						SendMessage(hListL, LB_ADDSTRING, 0, (LPARAM)(LPSTR)tempText);
						//Удаляем строку из правого списка
						SendMessage(hListR, LB_DELETESTRING, num, (LPARAM)(LPSTR)tempText);
					}

				};
				break;
			
			}
		}

		
	case WM_PAINT:
	{
		GetClientRect(hWnd, &rect);
		HDC hDC;
		PAINTSTRUCT ps;
		HGDIOBJ hfnt, hfntPrev;
		HRESULT hr;

		hDC = BeginPaint(hWnd, &ps);
		PLOGFONT plf = (PLOGFONT)LocalAlloc(LPTR, sizeof(LOGFONT));

		 
		if (str.orientation == 1)
		{
			plf->lfEscapement = 2700;
		}
		else
		{
			plf->lfEscapement = 0;
		}

		plf->lfWeight = 700;
		strcpy(plf->lfFaceName, "Segoe UI");
		hfnt = CreateFontIndirect(plf);
		hfntPrev = SelectObject(hDC, hfnt);
		SetTextColor(hDC, str.TextColor);
		SetBkColor(hDC, str.BGColor);
		TextOut(hDC, 600, 80, str.TEXT, strlen(str.TEXT));
		SelectObject(hDC, hfntPrev);
		DeleteObject(hfnt);

	
		EndPaint(hWnd, &ps);

		
	
	}; break;



	case WM_DESTROY:
	{
		
		PostQuitMessage(0);
	}; break;

	
	default: return DefWindowProc(hWnd, msg, wParam, lParam);
	}
	return 0l;
}
