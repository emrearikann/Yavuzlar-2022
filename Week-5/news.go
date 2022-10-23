package main

import (
	"encoding/json"
	"fmt"
	"io"
	"os"
	"strconv"
	"strings"

	"github.com/gocolly/colly"
)

var tmp string

type News struct {
	Title   string `json:"Title"`
	Content string `json:"Content"`
}

func main() {
	c := colly.NewCollector()

	file, err := os.Create("news.json")
	if err != nil {
		panic(err)
	}

	io.WriteString(file, "[")

	c.OnHTML(".category__list__item", func(e *colly.HTMLElement) {
		myTitle := e.ChildAttr(".category__list__item--cover img", "alt")
		myContent := e.ChildText("div a p")
		u, err := json.MarshalIndent(News{Title: myTitle, Content: myContent}, "", " ")
		if err != nil {
			panic(err)
		}
		fmt.Println(string(u))
		tmp += string(u) + ","
	})

	// scraping for 10 pages
	for i := 1; i <= 10; i++ {
		c.Visit("https://www.hurriyet.com.tr/gundem/?p=" + strconv.Itoa(i))
	}

	value := strings.Trim(tmp, ",")
	io.WriteString(file, value)

	io.WriteString(file, "]")
}
